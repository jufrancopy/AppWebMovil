<?php

namespace Database\Seeders;

use App\Appointment;
use Illuminate\Database\Seeder;

class AppointmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // factory(Appointment::class, 50)->states('patient')->create();
        Appointment::factory()->count(300)->create();
    }
}
