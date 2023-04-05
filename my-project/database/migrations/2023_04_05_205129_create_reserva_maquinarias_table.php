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
        Schema::create('reserva_maquinarias', function (Blueprint $table) {
            $table->id();
            $table->string('maquinaria_id');
            $table->string('user_id');
            $table->string('fecha_inicio');
            $table->string('fecha_fin');
            $table->string('dias');
            $table->string('precio_total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reserva_maquinarias');
    }
};
