<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

use Faker\Factory as FakerFactory;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        $fakeBr    = FakerFactory::create('pt_BR');
        
        $document  = $this->faker->boolean(15) ? $fakeBr->cpf : $fakeBr->cnpj;
        $type      = $this->faker->boolean(15) ? 'client' : 'shopkeeper';
    
        return [
            'name'     => $this->faker->unique()->name(),
            'password' => 'Teste@10',
            'document' => preg_replace("/[^0-9]/", '', $document),
            'email'    => $this->faker->unique()->safeEmail,
            'type'     => $type,
            'balance'  => 2000
        ];
    }
}
