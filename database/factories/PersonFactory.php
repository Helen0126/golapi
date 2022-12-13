<?php

namespace Database\Factories;

use App\Models\Cycle;
use App\Models\Person;
use App\Models\Type;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Person>
 */
class PersonFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Person::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $genero = fake()->randomElement(['male', 'female']);

        return [
            'names' => fake()->firstName($genero) . ' ' . fake()->firstName($genero),
            'last_names' => fake()->lastName() . ' ' . fake()->lastName(),
            'code' => fake()->unique()->randomNumber(9),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->unique()->randomNumber(9),
            'type_id' => Type::ESTUDIANTE,
            'gender' => $genero === 'male' ? 'Masculino' : 'Femenino',
            'cycle_id' => Cycle::pluck('id')->random(),
        ];
    }
}
