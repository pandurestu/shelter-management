<?php

use App\Models\Setting;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Setting::set('site_tagline', 'PENJAGAAN SATWA & BENCANA TERPADU');
        Setting::set('site_name', 'SHELTER MANAGEMENT SYSTEM');
        Setting::set('coordination_unit', 'Satgas Penjagaan Wilayah');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No-op
    }
};
