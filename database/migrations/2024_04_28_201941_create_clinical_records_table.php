<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClinicalRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //La tabla sirve para guardar el expediente de los pacientes
        Schema::create('clinical_records', function (Blueprint $table) {
            $table->id();
            $table->text('detail');

            // Agregar columna para la referencia al estudio asociado
            $table->unsignedBigInteger('study_id')->nullable();
            $table->foreign('study_id')->references('id')->on('studies');

            // Agregar columna para la referencia al ítem asociado
            $table->unsignedBigInteger('item_id')->nullable();
            $table->foreign('item_id')->references('id')->on('items');

            // Agregar columna para la referencia a la plantilla de formulario
            $table->unsignedBigInteger('form_template_id')->nullable();
            $table->foreign('form_template_id')->references('id')->on('form_templates');

            $table->unsignedBigInteger('patient_id');
            $table->foreign('patient_id')->references('id')->on('users');

            $table->unsignedBigInteger('doctor_id');
            $table->foreign('doctor_id')->references('id')->on('users');

            $table->unsignedBigInteger('appointment_id')->nullable();
            $table->foreign('appointment_id')->references('id')->on('appointments');

            $table->text('delete_reason')->nullable(); // Campo para el motivo de eliminación (opcional)
            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clinical_records');
    }
}
