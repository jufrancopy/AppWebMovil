<?php

namespace Database\Seeders;

use App\Models\FormTemplateField;
use Illuminate\Database\Seeder;

class FormTemplateFieldSeeder extends Seeder
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
                'description' => 'Presión arterial',
                'type' => 'text',
            ],

            [
                'name' => 'weight',
                'description' => 'Peso',
                'type' => 'number',
            ],

            [
                'name' => 'Mayor de edad?',
                'type' => 'checkbox',
            ],

        ];

        // Insertar los datos en la tabla items
        foreach ($fields as $field) {
            FormTemplateField::create($field);
        }
    }
}
