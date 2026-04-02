<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateClientRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'email' => 'nullable|email|unique:clients,email,' . $this->client,
            'phone' => 'nullable|string|unique:clients,phone,' . $this->client,
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Имя обязательно для заполнения',
            'email.email' => 'Неверный формат почты',
            'email.unique' => 'Клиент с такой почтой уже существует',
            'phone.unique' => 'Клиент с таким номером телефона уже существует'
        ];
    }
}
