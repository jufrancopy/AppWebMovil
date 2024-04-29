<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClinicalRecordFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //La tabla de campos de los registros clinicos
        Schema::create('clinical_record_fields', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('clinical_record_id');
            $table->enum('type', ['text', 'textarea', 'select', 'checkbox', 'radio']); // Ejemplo de tipos de campos

            //Relacion
            $table->foreign('clinical_record_id')->references('id')->on('clinical_record_templates');

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
        Schema::dropIfExists('clinical_record_fields');
    }
}
