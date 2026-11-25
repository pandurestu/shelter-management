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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shelter_id')->constrained('shelters')->cascadeOnDelete();
            $table->foreignId('officer_id')->constrained('officers')->cascadeOnDelete();
            $table->date('date');
            $table->string('day'); // Senin, Selasa, dst.
            $table->string('shift'); // Pagi, Siang, Malam
            $table->time('start_time')->default('07:00:00');
            $table->time('end_time')->default('15:00:00');
            $table->string('status')->default('Terjadwal'); // Sedang Bertugas, Siaga Shift, Terjadwal, Selesai Shift, Dibatalkan
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['date', 'shift']);
            $table->index(['officer_id', 'date']);
            $table->index('shelter_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
