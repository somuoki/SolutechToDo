<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class TaskCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|',
            'due_date' => 'date|after:yesterday',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'validation errors',
            'data' => $validator->errors(),
        ]));
    }

    public function messages()
    {
        return [
            'name.required' => 'Task name is required',
            'due_date.date' => 'The Due date needs to be a date',
            'due_date.after:yesterday' => 'The due date must be in the future',
        ];
    }
}
