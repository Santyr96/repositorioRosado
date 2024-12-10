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
        Schema::create('signups', function (Blueprint $table) {
            $table->id(); // Clave primaria autoincremental
            $table->foreignId('client_id')
                ->constrained('users')
                ->onDelete('cascade');
            $table->foreignId('hairdresser_id')
                ->constrained('hairdressers')
                ->onDelete('cascade');
            $table->timestamps();
            $table->unique(['client_id', 'hairdresser_id']); // Evita duplicados
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('signup');
    }
};
