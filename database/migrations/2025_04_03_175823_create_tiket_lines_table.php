<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use function Laravel\Prompts\table;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tiket_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_tiket')->constrained('tikets');
            $table->foreignId('id_producto')->constrained('productos');
            $table->integer('quantity');
            $table->integer('price');
            $table->integer('deleted')->default(0); //1 Borrado, 0 Activo
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tiket_lines');
    }
};
