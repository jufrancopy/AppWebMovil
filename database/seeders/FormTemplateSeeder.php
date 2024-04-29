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
                'name' => 'Formulario de Consentimiento Informado',
                'delete_reason' => null,
            ],

            [
                'name' => 'Formulario Quirúrgico',
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
