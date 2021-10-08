<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadVideosFormRequest extends FormRequest
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
           "file" => "required|mimes:mp4,ogx,oga,ogv,ogg,webm"
        ];
    }

    public function messages(){
        return [
            'file.required' => 'File is required',
            'file.mimes' => 'File is not in correct format.',
        ];
    }
}
