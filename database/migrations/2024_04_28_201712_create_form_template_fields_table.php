<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormTemplateFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //La tabla de campos de los registros clinicos
        Schema::create('form_template_fields', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('clinical_record_id');
            $table->enum('type', ['text', 'textarea', 'select', 'checkbox', 'radio']); // Ejemplo de tipos de campos

            //Relacion
            $table->foreign('clinical_record_id')->references('id')->on('form_templates');
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
        Schema::dropIfExists('form_template_fields');
    }
}
