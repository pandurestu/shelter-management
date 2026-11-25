<?php

use App\Models\ActivityLog;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Hash;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

$admin = User::firstOrCreate(
    ['email' => 'admin@shelter.com'],
    [
        'name' => 'Administrator Taman Safari',
        'role' => 'super_admin',
        'phone' => '0812-3456-7890',
        'password' => Hash::make('TamanSafari2026'),
    ]
);

$admin->email = 'admin@shelter.com';
$admin->password = Hash::make('TamanSafari2026');
$admin->save();

// Reassign any schedules or activity logs created by others to admin
Schedule::where('created_by', '!=', $admin->id)->update(['created_by' => $admin->id]);
ActivityLog::where('user_id', '!=', $admin->id)->update(['user_id' => $admin->id, 'user_name' => $admin->name]);

// Delete all other users
$deleted = User::where('id', '!=', $admin->id)->delete();

echo "Deleted {$deleted} other users.\n";
echo 'Total users now: '.User::count()."\n";
foreach (User::all() as $u) {
    echo "ID: {$u->id} | Email: {$u->email} | Name: {$u->name}\n";
}
