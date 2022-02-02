<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class Request extends FormRequest
{

    /**
     * Get the proper failed validation response for the request.
     *
     * @param Validator $validator
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws ValidationException
     */
    public function failedValidation(Validator $validator)
    {
        if ($this->expectsJson()) {
            throw new HttpResponseException(response()->json(['message' => 'validation failed', 'error' => $validator->getMessageBag()], 400));
        }

        throw (new ValidationException($validator))
            ->errorBag($this->errorBag)
            ->redirectTo($this->getRedirectUrl());
    }
}
