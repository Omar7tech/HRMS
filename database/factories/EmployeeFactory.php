<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $arabCountries = [
            'Algeria',
            'Bahrain',
            'Comoros',
            'Djibouti',
            'Egypt',
            'Iraq',
            'Jordan',
            'Kuwait',
            'Lebanon',
            'Libya',
            'Mauritania',
            'Morocco',
            'Oman',
            'Palestine',
            'Qatar',
            'Saudi Arabia',
            'Somalia',
            'Sudan',
            'Syria',
            'Tunisia',
            'United Arab Emirates',
            'Yemen'
        ];
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'national_id' => $this->faker->uuid,
            'nationality' => $this->faker->randomElement($arabCountries),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'date_of_birth' => $this->faker->date(),
            'email' => $this->faker->unique()->safeEmail,
            'phone_number' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'salary' => $this->faker->randomFloat(2, 1000, 10000),
            'emergency_contact' => $this->faker->phoneNumber,
            'cv' => null,
            'image' => null,
            'position_id' => function () {
                return \App\Models\Position::inRandomOrder()->first()->id;
            },
            'training' => $this->faker->boolean,
            'schedule_id' => null,
        ];
    }
}
