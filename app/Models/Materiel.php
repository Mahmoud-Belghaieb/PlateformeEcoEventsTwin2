<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materiel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'type',
        'quantity',
        'condition',
        'value',
        'image',
        'is_available',
        'event_id',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'quantity' => 'integer',
        'is_available' => 'boolean',
    ];

    // Relationships
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    // Scopes
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true)->where('quantity', '>', 0);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByCondition($query, $condition)
    {
        return $query->where('condition', $condition);
    }

    // Accessors
    public function getFormattedValueAttribute()
    {
        return number_format($this->value, 2) . ' DT';
    }

    /**
     * Compatibility accessor: some views expect a `category` attribute.
     * Map `category` to the `type` column so existing templates don't break.
     */
    public function getCategoryAttribute()
    {
        return $this->type;
    }
}
