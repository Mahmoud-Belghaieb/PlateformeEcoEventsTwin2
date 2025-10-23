<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id', 'user_id', 'type', 'position_id', 'status', 'motivation',
        'additional_info', 'registered_at', 'approved_at', 'approved_by',
        'rejection_reason', 'attended', 'rating', 'feedback',
    ];

    protected $casts = [
        'additional_info' => 'array',
        'registered_at' => 'datetime',
        'approved_at' => 'datetime',
        'attended' => 'boolean',
    ];

    // Relations
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    // Scopes
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeParticipants($query)
    {
        return $query->where('type', 'participant');
    }

    public function scopeVolunteers($query)
    {
        return $query->where('type', 'volunteer');
    }
}
