<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pet>
 */
class PetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'age' => '1',
            'type' => 'dog',
            'gender' => 'male',
            'image' => 'image/dog.jpeg',
            'price' => '100',
            'operation' => 'sell',
            'user_id' =>43 ,
            'category' => 'Dogs',
        ];
    }
}
