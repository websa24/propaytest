<?php

namespace Database\Factories;

use App\Helpers\SouthAfricanIdHelper;
use App\Helpers\SouthAfricanMobileHelper;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Person>
 */
class PersonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $birthDate = $this->faker->dateTimeBetween('-80 years', '-18 years');
        $saId = SouthAfricanIdHelper::generate($birthDate);

        return [
            'name' => $this->faker->firstName,
            'surname' => $this->faker->lastName,
            'sa_id_number' => $saId,
            'mobile_number' => SouthAfricanMobileHelper::generate(),
            'email' => $this->faker->unique()->safeEmail,
            'birth_date' => $birthDate->format('Y-m-d'),
            'language' => $this->faker->randomElement(['english', 'afrikaans', 'zulu', 'xhosa', 'sotho', 'tswana', 'venda', 'swati', 'ndebele']),
        ];
    }
}
