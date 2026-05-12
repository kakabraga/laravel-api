<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Se você usa Policy, pode deixar true
        // ou integrar com a policy:
        // return $this->user()->can('update', $this->route('customer'));

        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'email', 'max:255'],

            'document' => ['sometimes', 'string', 'max:14'],
            'type' => ['sometimes', 'in:cpf,cnpj'],

            'phone' => ['sometimes', 'string', 'max:20'],

            'address' => ['sometimes', 'string', 'max:255'],
            'city' => ['sometimes', 'string', 'max:100'],
            'state' => ['sometimes', 'string', 'size:2'],
            'zip_code' => ['sometimes', 'string', 'max:10'],
            'status' => ['sometimes', 'string', 'max:20'],
        ];
    }

    public function messages(): array
    {
        return [
            'type.in' => 'O tipo deve ser cpf ou cnpj',
            'state.size' => 'O estado deve ter 2 caracteres (UF)',
        ];
    }
}
