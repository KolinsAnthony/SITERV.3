<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('comprobantes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_rubro');
            $table->foreign('id_rubro')
                ->references('id')
                ->on('rubros')
                ->onDelete('cascade');
            $table->unsignedBigInteger('id_estudiante');
            $table->foreign('id_estudiante')
                ->references('id')
                ->on('estudiantes')
                ->onDelete('cascade');
            $table->string('estado');
            $table->date('fecha');
            $table->string('semestre');
            $table->string('comentario');
            $table->string('precionuevo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comprobantes');
    }
};
