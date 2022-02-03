<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeamUpdateRequest extends Request
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
            'name' => ['required', 'max:255', 'string'],
            'logoURI' => ['required', 'image'],
        ];
    }

    /**
     * Get the custom validation messages.
     *
     * @return string[]
     */
    public function messages()
    {
        return [
            'logoURI.required' => 'The logo uri field is required.',
            'logoURI.image' => 'The logo uri must be an image'
        ];
    }
}
