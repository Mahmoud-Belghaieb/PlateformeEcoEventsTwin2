<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'responsibilities', 'requirements', 'type',
        'required_count', 'hourly_rate', 'requires_training', 'is_active',
    ];

    protected $casts = [
        'hourly_rate' => 'decimal:2',
        'requires_training' => 'boolean',
        'is_active' => 'boolean',
    ];

    // Relations
    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function events()
    {
        return $this->belongsToMany(Event::class, 'registrations')
            ->distinct();
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }
}
