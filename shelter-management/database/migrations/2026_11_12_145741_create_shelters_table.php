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
        Schema::create('shelters', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->string('zone')->default('Zona Utara');
            $table->text('address')->nullable();
            $table->string('coordinator_name')->nullable();
            $table->string('coordinator_phone')->nullable();
            $table->integer('capacity')->default(300);
            $table->integer('current_occupancy')->default(0);
            $table->integer('guard_quota')->default(6);
            $table->string('risk_level')->default('sedang'); // rendah, sedang, tinggi
            $table->string('status')->default('siaga_penuh'); // siaga_penuh, rutin, perawatan, darurat
            $table->text('image_url')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shelters');
    }
};
