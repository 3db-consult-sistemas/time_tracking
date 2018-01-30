<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use App\Model\Helpers;
use App\Model\Record\RecordRepository;
use Illuminate\Foundation\Http\FormRequest;

class AbsenceRequests extends FormRequest
{
    use Helpers;

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
        return [
            'action' => 'required|in:open,close,cancel',
            'comments' => 'string|nullable|max:191',
            'from' => 'date_format:"Y-m-d H:i"|nullable',
            'duration' => 'numeric|min:5|max:540'
        ];
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

            // compruebo que el registro siga activo para poderse cancelar.
            if ($this->get('action') == 'cancel' && $recordRepository->active($id) == null) {
                $validator->errors()->add('action', 'Ausencia programada finalizada, no se puede cancelar.');
            }

            // compruebo que la fecha programada sea al menos 10 minutos superior a la actual.
            if (($dateTime = $this->toCarbon($this->get('from'))) != null) {
                if ($dateTime <= Carbon::now()->addMinute(10)) {
                    $validator->errors()->add('from', 'La fecha y hora programada debe ser al menos 10 minutos superior a la actual.');
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

        return [
            'id' => $this->route('entryId'),
            'user_id' => auth()->id(),
            'type' => $type,
            'comments' => $this->get('comments'),
            'check_in' => $this['from'],
            'duration' => $this['duration']
        ];
    }
}
