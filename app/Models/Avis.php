<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Avis extends Model
{
    use HasFactory;

    protected $table = 'avis';

    protected $fillable = [
        'user_id',
        'event_id',
        'rating',
        'title',
        'content',
        'is_approved',
        'approved_at',
        'approved_by',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'approved_at' => 'datetime',
        'rating' => 'integer',
    ];

    /**
     * Relation avec l'utilisateur qui a créé l'avis
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec l'événement
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Relation avec l'administrateur qui a approuvé l'avis
     */
    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Relation avec les commentaires
     */
    public function commentaires(): HasMany
    {
        return $this->hasMany(Commentaire::class);
    }

    /**
     * Commentaires approuvés seulement
     */
    public function commentairesApprouves(): HasMany
    {
        return $this->hasMany(Commentaire::class)->where('is_approved', true);
    }

    /**
     * Scope pour les avis approuvés
     */
    public function scopeApprouves($query)
    {
        return $query->where('is_approved', true);
    }

    /**
     * Scope pour les avis en attente
     */
    public function scopeEnAttente($query)
    {
        return $query->where('is_approved', false);
    }

    /**
     * Scope pour filtrer par note
     */
    public function scopeAvecNote($query, $rating)
    {
        return $query->where('rating', $rating);
    }

    /**
     * Calcul de la note moyenne pour un événement
     */
    public static function noteMoyenneEvent($eventId)
    {
        return static::where('event_id', $eventId)
            ->where('is_approved', true)
            ->avg('rating');
    }

    /**
     * Nombre total d'avis pour un événement
     */
    public static function nombreAvisEvent($eventId)
    {
        return static::where('event_id', $eventId)
            ->where('is_approved', true)
            ->count();
    }

    /**
     * Méthode pour obtenir le pourcentage de chaque note
     */
    public static function repartitionNotesEvent($eventId)
    {
        $total = static::nombreAvisEvent($eventId);
        if ($total == 0) {
            return [];
        }

        $repartition = [];
        for ($i = 1; $i <= 5; $i++) {
            $count = static::where('event_id', $eventId)
                ->where('is_approved', true)
                ->where('rating', $i)
                ->count();
            $repartition[$i] = [
                'count' => $count,
                'percentage' => $total > 0 ? round(($count / $total) * 100, 1) : 0,
            ];
        }

        return $repartition;
    }
}
