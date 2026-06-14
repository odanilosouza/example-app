<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Client>
 */
class ClientFactory extends Factory
{
    protected $model = Client::class;

    public function definition(): array
    {
        return [
            'razao_social' => $this->faker->company,
            'nome_fantasia' => $this->faker->companySuffix,
            'cnpj' => $this->faker->unique()->numerify('########0001##'),
            'email' => $this->faker->companyEmail,
            'telefone' => $this->faker->phoneNumber,
            'endereco' => $this->faker->streetAddress,
            'cidade' => $this->faker->city,
            'estado' => $this->faker->stateAbbr,
            'cep' => $this->faker->postcode,
            'logo_path' => null,
            'status' => 'ativo',
            'observations' => null,
            'registered_at' => now(),
        ];
    }
}
