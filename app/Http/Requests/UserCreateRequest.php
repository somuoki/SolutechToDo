<?php

namespace App\Http\Requests;

use HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => [
                'required',
                Password::min(6)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->uncompromised()
            ],
            'password_confirmation' => 'required|same:password'
        ];
    }

    /**
     * @throws HttpResponseException
     */
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'validation errors',
            'data' => $validator->errors(),
        ]));
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Your Name is required',
            'email.unique' => 'This email already exists. Try to Log in',
            'email.email' => 'use a valid email address',
            'password.required' => 'Input a password',
            'password_confirmation.required' => 'Confirm your password',
            'password_confirmation.same:password' => 'The confirm password needs to be the same as the password',
        ];
    }
}
