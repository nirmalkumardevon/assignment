<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlayerUpdateRequest extends Request
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
            'firstName' => ['required', 'max:255', 'string'],
            'lastName' => ['required', 'max:255', 'string'],
            'playerImageURI' => ['required', 'image'],
            'team_id' => ['required', 'exists:teams,id'],
        ];
    }

    /**
     * Get custom validation messages.
     *
     * @return string[]
     */
    public function messages()
    {
        return [
            'playerImageURI.required' => 'The player image uri field is required.',
            'playerImageURI.image' => 'The player image uri must be an image.',
        ];
    }
}
