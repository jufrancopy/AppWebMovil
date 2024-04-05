<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            // 1
            'name' => 'Julio Franco',
            'email' => 'jucfra23@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('jcf3458435'), // password
            'role' => 'admin',
        ]);
        User::create([
            // 2
            'name' => 'Paciente Test',
            'email' => 'paciente1@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('jcf3458435'), // password
            'role' => 'paciente',
        ]);
        User::create([
            // 3
            'name' => 'Medico Test',
            'email' => 'medico1@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('jcf3458435'), // password
            'role' => 'doctor',
        ]);

        // factory(User::class, 50)->states('patient')->create();
        // User::factory()->count(50)->states('patient')->create();
        User::factory()->count(50)->patient()->create();
    }
}
