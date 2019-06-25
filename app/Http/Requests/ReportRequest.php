<?php

namespace App\Http\Requests;

use App\User;
use Carbon\Carbon;
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
            'userName' => 'nullable|string',
            'year' => 'required|numeric|min:2018'
        ];
    }

    /**
     * Format the input data to process.
     *
     * @return array
     */
    public function formatData()
    {
        $this['userId'] = null;
        $this['from'] = $this['year'] . '-01-01';
        $this['to'] = $this['year'] . '-12-31';

        if (! isset($this['userName']) || $this['userName'] == null) {
            return $this;
        }

        if (($user = User::where('username', $this['userName'])->first()) != null) {
            $this['userId'] = $user->id;
        }

        return $this;
    }
}
