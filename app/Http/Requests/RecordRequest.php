<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
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
            'name' => 'string|nullable|min:4',
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
        $this['aggregate'] = $this['aggregate'] != null ? $this['aggregate'] : 'day';
        $this['from'] = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this['to'] = Carbon::now()->format('Y-m-d');
        $this['userName'] = auth()->id();

        if (Gate::check('checkrole', 'super_admin') ||
            Gate::check('checkrole', 'admin') &&
            $this['name'] != null) {
            $this['name'] = $this['name'];
            $this['userName'] = $this['name'];
        }

        return $this;
    }
}
