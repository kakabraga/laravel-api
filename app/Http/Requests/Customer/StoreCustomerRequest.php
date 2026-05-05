<?php

namespace App\Http\Requests\Customer;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'     => ['required', 'string', 'max:100'],
            'email'    => ['required', 'email', 'unique:customers,email'],
            'document' => ['required', 'string', 'unique:customers,document'],
            'type'     => ['required', 'in:cpf,cnpj'],
            'phone'    => ['required', 'string', 'max:15'],
            'address'  => ['required', 'string', 'max:255'],
            'city'     => ['required', 'string', 'max:100'],
            'state'    => ['required', 'string', 'size:2'],
            'zip_code' => ['required', 'string', 'min:8', 'max:9'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'     => 'O nome é obrigatório.',
            'name.string'       => 'O nome deve ser um texto.',
            'name.max'          => 'O nome deve ter no máximo 100 caracteres.',

            'email.required'    => 'O e-mail é obrigatório.',
            'email.email'       => 'O e-mail informado é inválido.',
            'email.unique'      => 'Este e-mail já está cadastrado.',

            'document.required' => 'O documento é obrigatório.',
            'document.string'   => 'O documento deve ser um texto.',
            'document.unique'   => 'Este documento já está cadastrado.',

            'type.required'     => 'O tipo de documento é obrigatório.',
            'type.in'           => 'O tipo deve ser cpf ou cnpj.',

            'phone.required'    => 'O telefone é obrigatório.',
            'phone.string'      => 'O telefone deve ser um texto.',
            'phone.max'         => 'O telefone deve ter no máximo 15 caracteres.',

            'address.required'  => 'O endereço é obrigatório.',
            'address.string'    => 'O endereço deve ser um texto.',
            'address.max'       => 'O endereço deve ter no máximo 255 caracteres.',

            'city.required'     => 'A cidade é obrigatória.',
            'city.string'       => 'A cidade deve ser um texto.',
            'city.max'          => 'A cidade deve ter no máximo 100 caracteres.',

            'state.required'    => 'O estado é obrigatório.',
            'state.size'        => 'O estado deve ter exatamente 2 caracteres.',

            'zip_code.required' => 'O CEP é obrigatório.',
            'zip_code.size'     => 'O CEP deve ter exatamente 9 caracteres.',
        ];
    }
}