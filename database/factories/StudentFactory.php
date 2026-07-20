<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'student_id' => 'STU-'.fake()->unique()->numerify('######'),
            'date_of_birth' => fake()->dateTimeBetween('-20 years', '-15 years'),
            'grade_level' => fake()->randomElement(['9', '10', '11', '12']),
            'status' => fake()->randomElement(['active', 'active', 'active', 'inactive', 'graduated']),
        ];
    }
}
