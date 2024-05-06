<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //La tabla de campos de los registros clinicos
        Schema::create('form_fields', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->string('label');
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
        Schema::dropIfExists('form_fields');
    }
}
