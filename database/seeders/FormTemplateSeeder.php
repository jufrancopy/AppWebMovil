<?php

namespace Database\Seeders;

use App\Models\FormTemplate;
use Illuminate\Database\Seeder;

class FormTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Datos de ejemplo para los items
        $templates = [
            [
                'name' => 'Plantilla de Historia Clínica General',
                'description' => 'Plantilla aplicada a la Historia Clínica General',
                'with_odontogram' => true,
                'delete_reason' => null,
            ],

            [
                'name' => 'Plantilla de Examen Físico',
                'description' => 'Plantilla aplicada al Examen Físico',
                'with_odontogram' => false,
                'delete_reason' => null,
            ],
            // Agrega más datos de ejemplo según sea necesario
        ];

        // Insertar los datos en la tabla items
        foreach ($templates as $template) {
            FormTemplate::create($template);
        }
    }
}
