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
                'name'=>'Presión arterial',
                'form_template_id' => 1,
                'type' => 'text',
            ],

            [
                'name'=>'Peso',
                'form_template_id' => 1,
                'type' => 'textarea',
            ],

            [
                'name'=>'Estatura',
                'form_template_id' => 1,
                'type' => 'checkbox',
            ],
            
        ];

        // Insertar los datos en la tabla items
        foreach ($fields as $field) {
            FormTemplateField::create($field);
        }
    }
}
