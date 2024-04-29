<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

use Illuminate\Support\Str;

class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $doctorIds = User::doctors()->pluck('id');
        $patientIds = User::patients()->pluck('id');
        $scheduled = $this->faker->dateTimeBetween('-1 years', 'now');
        $scheduled_date = $scheduled->format('Y-m-d');
        $scheduled_time = $scheduled->format('H:i:s');

        $types = ['Consulta', 'Examen', 'Operacion'];
        $statuses = ['Atendida', 'Cancelada'];

        return [
            "description" => $this->faker->sentence(5),
            "specialty_id" => $this->faker->numberBetween(1, 3),
            "doctor_id" => $this->faker->randomElement($doctorIds),
            "patient_id" => $this->faker->randomElement($patientIds),
            "scheduled_date" => $scheduled_date,
            "scheduled_time" => $scheduled_time,
            "type" => $this->faker->randomElement($types),
            "status" => $this->faker->randomElement($statuses)
        ];
    }
}
