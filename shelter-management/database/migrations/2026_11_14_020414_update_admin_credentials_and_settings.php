<?php

use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Create or update user admin@shelter.com with password TamanSafari2026
        $admin = User::updateOrCreate(
            ['email' => 'admin@shelter.com'],
            [
                'name' => 'Administrator Taman Safari',
                'phone' => '0812-3456-7890',
                'role' => 'super_admin',
                'avatar' => 'https://lh3.googleusercontent.com/aida/ALJJyrB_4SeJN0hBVsUaQZSaPUtqD_UZdZaDySOnP-ks0pSur7WKVQ4HpFveXs56hl57Pk3cXbkml94LwFis0JLihaqdQp0M13iiTU6ObS9Eqd4CyxaVt6iG4jwZtoXOraiCuR_nzIbkGA8BWaA65PoesTJVxG_9WnJ3XegKsZr9ESUDLom-pjL9CKFkO7hrZXXmJWYikNTorGIHOSc4MT-HHSm_11plupnLgnh5BBPi7Vim',
                'password' => Hash::make('TamanSafari2026'),
            ]
        );

        // Hapus akun lain selain admin@shelter.com
        User::where('id', '!=', $admin->id)->delete();

        // 2. Remove Live System Plotting tagline from settings
        Setting::set('site_tagline', '');
        Setting::set('site_name', 'Shelter Management System');
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
