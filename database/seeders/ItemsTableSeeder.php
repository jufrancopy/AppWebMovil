<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;

class ItemsTableSeeder extends Seeder
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
                'name' => 'Gasas estériles',
                'description' => 'Gasas de algodón para uso médico estériles.',
                'price' => 10.50,
                'type' => 'supplies',
                'delete_reason' => null,
            ],
            [
                'name' => 'Paracetamol',
                'description' => 'Medicamento analgésico y antipirético.',
                'price' => 5.75,
                'type' => 'medicines',
                'delete_reason' => null,
            ],
            // Agrega más datos de ejemplo según sea necesario
        ];

        // Insertar los datos en la tabla items
        foreach ($items as $item) {
            Item::create($item);
        }
    }
}
