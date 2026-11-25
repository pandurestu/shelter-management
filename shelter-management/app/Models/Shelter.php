<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shelter extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'zone',
        'address',
        'coordinator_name',
        'coordinator_phone',
        'capacity',
        'current_occupancy',
        'guard_quota',
        'risk_level',
        'status',
        'image_url',
        'description',
    ];

    public function officers(): HasMany
    {
        return $this->hasMany(Officer::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    public function todaySchedules(): HasMany
    {
        return $this->hasMany(Schedule::class)->whereDate('date', today());
    }

    public function getActiveOfficersCountAttribute(): int
    {
        return $this->officers()->where('status', 'Aktif')->count();
    }
}
