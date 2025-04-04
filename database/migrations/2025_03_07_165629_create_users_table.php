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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('name');
            $table->string('surname');
            $table->string('password'); // Hashed password
            $table->string('old_password')->nullable(); // Old password for verification
            $table->integer('role')->default(0); // 0 - User, 1 - Admin
            $table->integer("deleted")->default(0); //1 Borrado, 0 Activo
            $table->date('birth_date');
            $table->integer('vendor')->default(0); // 0 - No es vendedor, 1 - Es vendedor
            $table->integer('gender');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
