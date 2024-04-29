<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'ci' => $this->faker->randomNumber(7, true),
            'address' => $this->faker->address,
            'phone' => $this->faker->e164PhoneNumber,
            'role' => $this->faker->randomElement(['patient', 'doctor'])
        ];
    }

    public function patient()
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'patient'
            ];
        });
    }

    public function doctor()
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'doctor'
            ];
        });
    }
}
