<?php

namespace Database\Seeders;

use App\Models\ClinicalRecord;
use Illuminate\Database\Seeder;

class ClinicalRecordsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Crear registros clínicos de ejemplo con información de los dientes
        $clinicalRecords = [
            [
                'detail' => 'Registro clínico de prueba 1',
                'teeth_information' => json_encode([
                    'l18' => ['estado' => 'fractura'],
                    'b20' => ['estado' => 'fractura'],
                ]),
                'study_id' => 1,
                'item_id' => 1,
                'form_template_id' => 1,
                'patient_id' => 1,
                'doctor_id' => 1,
                'appointment_id' => 1,
                'delete_reason' => null,
            ],
            [
                'detail' => 'Registro clínico de prueba 2',
                'teeth_information' => json_encode([
                    'lleche55' => ['estado' => 'restauracion'],
                    'tleche55' => ['estado' => 'restauracion'],

                ]),
                'study_id' => 2,
                'item_id' => 2,
                'form_template_id' => 2,
                'patient_id' => 2,
                'doctor_id' => 2,
                'appointment_id' => 2,
                'delete_reason' => null,
            ]
        ];

        foreach ($clinicalRecords as $clinicalRecord) {
            ClinicalRecord::create($clinicalRecord);
        }
    }
}
