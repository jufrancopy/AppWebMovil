<?php

namespace Database\Seeders;

use App\Models\ClinicalRecordTemplate;
use Illuminate\Database\Seeder;
use Database\Seeders\UsersTableSeeder;
use Database\Seeders\SpecialtiesTableSeeder;
use Database\Seeders\WorkDaysTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UsersTableSeeder::class,
            SpecialtiesTableSeeder::class,
            WorkDaysTableSeeder::class,
            AppointmentsTableSeeder::class,
            StudiesTableSeeder::class,
            ItemsTableSeeder::class,
            FormTemplateSeeder::class,
            FormTemplateFieldSeeder::class
        ]);
    }
}
