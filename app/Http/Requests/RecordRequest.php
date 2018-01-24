<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class RecordRequest extends FormRequest
{
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
            'name' => 'string|nullable',
            'aggregate' => 'in:day,week,record'
        ];
    }

    /**
     * Format the input data to process.
     *
     * @return array
     */
    public function formatData()
    {
        $data = [
            'aggregate' => $this['aggregate'],
            'user' => null
        ];

        $data['aggregate'] = $this->get('aggregate') != null
            ? $this->get('aggregate')
            : 'day';

        $data['to'] = Carbon::now()->format('Y-m-d');
        $data['from'] = Carbon::now()->startOfMonth()->format('Y-m-d');

            // Si autorizado
        // if (isAdmin) {
        $data['user'] = $this->get('name') != null
            ? $this->get('name')
            : null;
        // }

        $data['user'] = auth()->id();

        return $data;
    }
}
