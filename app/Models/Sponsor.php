<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'logo',
        'website',
        'contact_email',
        'contact_phone',
        'sponsorship_level',
        'contribution_amount',
        'is_active',
    ];

    protected $casts = [
        'contribution_amount' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function produits()
    {
        return $this->hasMany(Produit::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByLevel($query, $level)
    {
        return $query->where('sponsorship_level', $level);
    }
}
