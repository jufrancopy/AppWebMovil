<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Specialty;
use App\Models\User;

class SpecialtiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $specialties = [
            'Oftalmologia',
            'Reumatología',
            'Cardiologia'
        ];

        foreach ($specialties as $specialtyName) {
            $specialty = Specialty::create([
                'name' => $specialtyName
            ]);

            $specialty->users()->saveMany(
                // factory(User::class, 3)->states('doctor')->make();
                // User::factory()->count(3)->states('doctor')->make()
                User::factory()->count(3)->doctor()->make()
            );
        }

        // Medico Test
        User::find(3)->specialties()->save($specialty);
    }
}
