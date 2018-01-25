<?php

namespace App\Http\Requests;

use App\Model\Helpers;
use Illuminate\Foundation\Http\FormRequest;

class ReportRequest extends FormRequest
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
            'userName' => 'string|nullable|min:4',
            'aggregate' => 'required|in:day,week,month,record',
            'from' => 'required|date_format:"Y-m-d"|before_or_equal:to',
            'to' => 'required|date_format:"Y-m-d"|after_or_equal:from'
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

            $userName = $this->get('userName');
            $aggregate = $this->get('aggregate');
            $from = $this->toCarbon($this->get('from'), 'Y-m-d');
            $to = $this->toCarbon($this->get('to'), 'Y-m-d');
            $diff = $from->diffInDays($to);

            if ($userName == null) {
                if ($aggregate == 'record' && $diff > 7) {
                    return $validator->errors()->add('aggregate', 'No se puede exportar mas de 7 días de todos los usuarios a nivel de registro.');
                }

                if ($aggregate == 'day' && $diff > 31) {
                    return $validator->errors()->add('aggregate', 'No se puede exportar mas de un mes de todos los usuarios a nivel de día.');
                }
            }

            if ($aggregate == 'record' && $diff > 365) {
                return $validator->errors()->add('aggregate', 'No se puede exportar mas de un año a nivel de registro.');
            }

            if ($aggregate == 'month' && $diff > 365) {
                return $validator->errors()->add('aggregate', 'No se puede exportar el agregado mensual de mas de un año.');
            }

            if ($aggregate == 'week' && $diff > 365) {
                return $validator->errors()->add('aggregate', 'No se puede exportar el agregado semanal de mas de un año.');
            }

            if ($aggregate == 'day' && $diff > 90) {
                return $validator->errors()->add('aggregate', 'No se puede exportar el agregado diario de mas de 3 meses.');
            }
        });
    }
}
