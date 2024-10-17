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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')
            ->constrained('users')
            ->onDelete('cascade');
            $table->foreignId('service_id')
            ->constrained('services')
            ->onDelete('cascade');
            $table->foreignId('hairdresser_id')
            ->constrained('hairdressers')
            ->onDelete('cascade');
            $table->dateTime('date');
            $table->enum('status', ['pendiente', 'confirmado', 'cancelado']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
