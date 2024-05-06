<?php

namespace Database\Seeders;

use App\Models\FormField;
use Illuminate\Database\Seeder;

class FormFieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Datos de ejemplo para los items
        $fields = [
            [
                'name' => 'blood_pressure',
                'label' => 'Presión arterial',
                'type' => 'text',
            ],

            [
                'name' => 'weight',
                'label' => 'Peso',
                'type' => 'number',
            ],

            [
                'name' => 'Mayor de edad?',
                'label' => 'Presión arterial',
                'type' => 'checkbox',
            ],

        ];

        // Insertar los datos en la tabla items
        foreach ($fields as $field) {
            FormField::create($field);
        }
    }
}
