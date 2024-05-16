<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;
use Faker\Factory as Faker;

class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Populate employees table with fake data
        for ($i = 0; $i < 100; $i++) { // Adjust the number of records you want to create
            Employee::create([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'national_id' => $faker->ean13,
                'nationality' => $faker->country,
                'gender' => $faker->randomElement(['male', 'female']),
                'date_of_birth' => $faker->date,
                'email' => $faker->unique()->safeEmail,
                'phone_number' => $faker->phoneNumber,
                'address' => $faker->address,
                'salary' => $faker->randomNumber(5),
                'emergency_contact' => $faker->phoneNumber,
                'cv' => 'path/to/cv.pdf', // Replace with actual path if available
                'image' => 'path/to/image.jpg', // Replace with actual path if available
                'position' => $faker->randomElement(['developer', 'manager', 'assistant']),
                'training' => $faker->boolean(50),
            ]);
        }
    }
}
