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
                'clinical_record_id' => 1,
                'type' => 'text',
            ],

            [
                'clinical_record_id' => 1,
                'type' => 'textarea',
            ],

            [
                'clinical_record_id' => 1,
                'type' => 'checkbox',
            ],
            
        ];

        // Insertar los datos en la tabla items
        foreach ($fields as $field) {
            FormTemplateField::create($field);
        }
    }
}
