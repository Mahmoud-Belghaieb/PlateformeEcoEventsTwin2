<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Commentaire extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'avis_id',
        'parent_id',
        'content',
        'is_approved',
        'approved_at',
        'approved_by',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'approved_at' => 'datetime',
    ];

    /**
     * Relation avec l'utilisateur qui a créé le commentaire
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec l'avis
     */
    public function avis(): BelongsTo
    {
        return $this->belongsTo(Avis::class);
    }

    /**
     * Relation avec l'administrateur qui a approuvé le commentaire
     */
    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Relation avec le commentaire parent (pour les réponses)
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Commentaire::class, 'parent_id');
    }

    /**
     * Relation avec les réponses (commentaires enfants)
     */
    public function reponses(): HasMany
    {
        return $this->hasMany(Commentaire::class, 'parent_id');
    }

    /**
     * Réponses approuvées seulement
     */
    public function reponsesApprouvees(): HasMany
    {
        return $this->hasMany(Commentaire::class, 'parent_id')
            ->where('is_approved', true);
    }

    /**
     * Scope pour les commentaires approuvés
     */
    public function scopeApprouves($query)
    {
        return $query->where('is_approved', true);
    }

    /**
     * Scope pour les commentaires en attente
     */
    public function scopeEnAttente($query)
    {
        return $query->where('is_approved', false);
    }

    /**
     * Scope pour les commentaires de niveau racine (pas de parent)
     */
    public function scopeRacine($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Vérifier si c'est une réponse
     */
    public function estReponse(): bool
    {
        return ! is_null($this->parent_id);
    }
}
