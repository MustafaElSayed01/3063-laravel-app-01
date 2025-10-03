<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'nullable|string|between:2,100',
            'email' => 'nullable|string|email|max:100|unique:users',
            'password' => 'nullable|string|min:6',
            'mobile' => 'nullable|string|size:10|unique:users',
            'role' => 'nullable|string|in:admin,user,manager',
        ];
    }
}
