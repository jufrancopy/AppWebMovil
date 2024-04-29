<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Study;


class StudiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Array de estudios médicos de ejemplo
        $studies = [
            ['name' => 'Análisis de sangre', 'description' => 'Prueba para medir diferentes componentes de la sangre.', 'price' => 50.00],
            ['name' => 'Radiografía de tórax', 'description' => 'Imagen de rayos X del pecho.', 'price' => 75.00],
            // Agrega más estudios médicos aquí según sea necesario
        ];

        // Itera sobre el array de estudios médicos y crea cada uno en la base de datos
        foreach ($studies as $study) {
            Study::create($study);
        }
    }
}
