<?php

namespace App\Http\Requests\Product;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:100'],

            'quantity' => ['required', 'integer', 'min:0'],

            'weight' => ['required', 'numeric', 'min:0'],

            'price' => ['required', 'numeric', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome do produto é obrigatório.',
            'name.string' => 'O nome do produto deve ser um texto.',
            'name.max' => 'O nome do produto deve ter no máximo 100 caracteres.',

            'quantity.required' => 'A quantidade é obrigatória.',
            'quantity.integer' => 'A quantidade deve ser um número inteiro.',
            'quantity.min' => 'A quantidade não pode ser negativa.',

            'weight.required' => 'O peso é obrigatório.',
            'weight.numeric' => 'O peso deve ser um número.',
            'weight.min' => 'O peso não pode ser negativo.',

            'price.required' => 'O preço é obrigatório.',
            'price.numeric' => 'O preço deve ser um número.',
            'price.min' => 'O preço não pode ser negativo.',
        ];
    }

}
