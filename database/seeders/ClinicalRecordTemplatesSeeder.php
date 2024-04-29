<?php

namespace Database\Seeders;

use App\Models\FormTemplate;
use Illuminate\Database\Seeder;

class ClinicalRecordTemplatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Datos de ejemplo para los items
        $items = [
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
        foreach ($items as $item) {
            FormTemplate::create($item);
        }

    }
}
