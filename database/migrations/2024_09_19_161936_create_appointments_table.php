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
            ->nullable()
            ->constrained('users')
            ->onDelete('cascade');
            $table->string('unregistered_client')
            ->max(80)
            ->nullable();
            $table->foreignId('service_id')
            ->constrained('services')
            ->onDelete('cascade');
            $table->foreignId('hairdresser_id')
            ->constrained('hairdressers')
            ->onDelete('cascade');
            $table->dateTime('start');
            $table->dateTime('end');
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
