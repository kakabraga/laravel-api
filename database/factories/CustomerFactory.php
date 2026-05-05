<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Customer;

class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    public function definition(): array
    {
        // Decide aleatoriamente entre CPF ou CNPJ
        $type = $this->faker->randomElement(['cpf', 'cnpj']);

        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),

            // Gera documento baseado no tipo
            'document' => $type === 'cpf'
                ? $this->faker->numerify('###########')   // 11 dígitos
                : $this->faker->numerify('##############'), // 14 dígitos

            'type' => $type,

            'phone' => $this->faker->numerify('###########'), // (DDD + número)

            'address' => $this->faker->streetAddress(),
            'city' => $this->faker->city(),
            'state' => $this->faker->stateAbbr(),

            'zip_code' => $this->faker->numerify('########'), // 8 dígitos
        ];
    }
}
