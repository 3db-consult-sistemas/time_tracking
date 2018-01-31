<?php

namespace App\Http\Requests;

use App\Model\Helpers;
use Illuminate\Foundation\Http\FormRequest;

class TimetableRequest extends FormRequest
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
            'user_id' => 'exists:users,id',
            'from_date' => 'date_format:"Y-m-d"',
            'monday' => 'numeric|min:0|max:600',
            'tuesday' => 'numeric|min:0|max:600',
            'wednesday' => 'numeric|min:0|max:600',
            'thursday' => 'numeric|min:0|max:600',
            'friday' => 'numeric|min:0|max:600',
            'saturday' => 'numeric|min:0|max:600',
            'sunday' => 'numeric|min:0|max:600'
        ];
    }

    /**
     * Format the input data to process.
     *
     * @return array
     */
    public function formatData()
    {
        return [
            'user_id' => $this['user_id'],
            'from_date' => $this->toCarbon($this['from_date'], 'Y-m-d'),
            'monday' => $this['monday'] == 0 ? null : $this['monday'] * 60,
            'tuesday' => $this['tuesday'] == 0 ? null : $this['tuesday'] * 60,
            'wednesday' => $this['wednesday'] == 0 ? null : $this['wednesday'] * 60,
            'thursday' => $this['thursday'] == 0 ? null : $this['thursday'] * 60,
            'friday' => $this['friday'] == 0 ? null : $this['friday'] * 60,
            'saturday' => $this['saturday'] == 0 ? null : $this['saturday'] * 60,
            'sunday' => $this['sunday'] == 0 ? null : $this['sunday'] * 60
        ];
    }
}
