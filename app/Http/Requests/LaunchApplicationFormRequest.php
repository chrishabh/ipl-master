<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LaunchApplicationFormRequest extends FormRequest
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
            "device_id" => "required",
           "serial_number" => "required",
           "andriod_id" => "required"
        ];
    }

    public function messages(){
        return [
            #'id.required' => 'File id is required',
            'device_id.required' => 'Device id is required',
            'serial_number.required' => 'Serial number is required',
            'andriod_id.required' => 'Andriod id is required',
        ];
    }
}
