<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use App\Model\Helpers;
use Illuminate\Validation\Rule;
use App\Model\Record\RecordRepository;
use Illuminate\Foundation\Http\FormRequest;

class AbsenceRequests extends FormRequest
{
	use Helpers;

	protected $durationMin;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'action' => 'required|in:open,close,cancel',
            'absence_type' => ['nullable', Rule::in(array_keys(config('options.absence_options')))],
            'comments' => 'string|nullable|max:191',
            'from' => 'date_format:"Y-m-d H:i"|nullable',
		];

		$this->durationMin = config('options.break_duration');

		if ($this['absence_type'] != 'descanso') {
			$this->durationMin = config('options.absence_duration.min');
			$rules['duration'] = 'numeric|min:' . $this->durationMin . '|max:' . config('options.absence_duration.max');
		}

		return $rules;
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            $id = auth()->id();
			$recordRepository = New RecordRepository();

			if ($this['absence_type'] == 'descanso') {
				$this['duration'] = $this->durationMin;
			}

            // compruebo que el registro siga activo para poderse cancelar.
            if ($this->get('action') == 'cancel' && $recordRepository->active($id) == null) {
                $validator->errors()->add('action', 'Ausencia programada finalizada, no se puede cancelar.');
            }

            // creando ausencia, compruebo que tenga comentario.
            if ($this->get('action') == 'open' && $this->get('absence_type') == 'otros' && $this->get('comments') == null) {
                $validator->errors()->add('comments', 'Comentario obligatorio al programar una ausencia del tipo "otros".');
            }

            // compruebo que la fecha programada sea al menos 'options.absence_duration.min' minutos superior a la actual.
            if (($dateTime = $this->toCarbon($this->get('from'))) != null) {
                if ($dateTime <= Carbon::now()->addMinute($this->durationMin)) {
                    $validator->errors()->add('from', 'La fecha y hora programada debe ser al menos ' . $this->durationMin . ' minutos superior a la actual.');
                }
                $this['from'] = $dateTime;
            }
        });
    }

    /**
     * Format the input data to process.
     *
     * @return array
     */
    public function formatData()
    {
        $type = $this->get('action') == 'close' || $this->get('action') == 'cancel'
            ? 'ordinaria'
            : 'ausencia';

        if ($this->get('planned') == null) {
            $this['from'] = null;
            $this['duration'] = null;
        }

        $duration = $this->get('absence_type') == 'descanso'
            ? config('options.break_duration')
            : $this['duration'];

        $comment = $this->get('absence_type') == 'otros'
            ? $this->get('comments')
            : $this->get('absence_type');

        return [
            'id' => $this->route('entryId'),
            'user_id' => auth()->id(),
            'type' => $type,
            'ip' => ip2long($this->getIp()),
            'comments' => $comment,
            'check_in' => $this['from'],
            'duration' => $duration
        ];
    }
}
