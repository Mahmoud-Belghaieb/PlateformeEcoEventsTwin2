<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'description', 'short_description', 'category_id', 'venue_id',
        'created_by', 'approved_by', 'start_date', 'end_date', 'registration_start', 
        'registration_end', 'max_participants', 'price', 'status', 'requirements', 
        'featured_image', 'gallery', 'is_featured', 'requires_approval', 'cancellation_policy',
        'approved_at', 'rejection_reason'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'registration_start' => 'datetime',
        'registration_end' => 'datetime',
        'approved_at' => 'datetime',
        'requirements' => 'array',
        'gallery' => 'array',
        'is_featured' => 'boolean',
        'requires_approval' => 'boolean',
        'price' => 'decimal:2',
    ];

    // ====== RELATION MANY-TO-MANY AVEC USERS VIA REGISTRATIONS ======
    
    /**
     * Relation Many-to-Many avec Users via la table registrations
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'registrations')
                    ->withPivot('type', 'position_id', 'status', 'motivation', 'additional_info',
                               'registered_at', 'approved_at', 'approved_by', 'rejection_reason',
                               'attended', 'rating', 'feedback')
                    ->withTimestamps();
    }

    /**
     * Tous les enregistrements (participants + bénévoles)
     */
    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    /**
     * Participants uniquement
     */
    public function participants()
    {
        return $this->belongsToMany(User::class, 'registrations')
                    ->wherePivot('type', 'participant')
                    ->withPivot('status', 'registered_at', 'attended', 'rating', 'feedback')
                    ->withTimestamps();
    }

    /**
     * Bénévoles uniquement
     */
    public function volunteers()
    {
        return $this->belongsToMany(User::class, 'registrations')
                    ->wherePivot('type', 'volunteer')
                    ->withPivot('position_id', 'status', 'motivation', 'registered_at')
                    ->withTimestamps();
    }

    // ====== AUTRES RELATIONS ======

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function positions()
    {
        return $this->belongsToMany(Position::class, 'event_positions')
                    ->withPivot('required_count', 'filled_count', 'event_specific_rate',
                               'additional_requirements', 'application_deadline', 'is_active')
                    ->withTimestamps();
    }

    /**
     * Relation avec les avis
     */
    public function avis()
    {
        return $this->hasMany(Avis::class);
    }

    /**
     * Avis approuvés seulement
     */
    public function avisApprouves()
    {
        return $this->hasMany(Avis::class)->where('is_approved', true);
    }

    // ====== MÉTHODES UTILES ======

    /**
     * Vérifie si un utilisateur est inscrit à cet événement
     */
    public function isUserRegistered($userId)
    {
        return $this->registrations()->where('user_id', $userId)->exists();
    }

    /**
     * Obtient l'inscription d'un utilisateur pour cet événement
     */
    public function getUserRegistration($userId)
    {
        return $this->registrations()->where('user_id', $userId)->first();
    }

    /**
     * Calcul de la note moyenne
     */
    public function noteMoyenne()
    {
        return $this->avisApprouves()->avg('rating') ?? 0;
    }

    /**
     * Nombre total d'avis
     */
    public function nombreAvis()
    {
        return $this->avisApprouves()->count();
    }

    // ====== SCOPES ======

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>', now());
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    // ====== RELATIONS AVEC LES AVIS ======
    
    /**
     * Relation avec les avis
     */
    public function avis()
    {
        return $this->hasMany(Avis::class);
    }

    /**
     * Avis approuvés seulement
     */
    public function avisApprouves()
    {
        return $this->hasMany(Avis::class)->where('is_approved', true);
    }

    /**
     * Calcul de la note moyenne
     */
    public function noteMoyenne()
    {
        return $this->avisApprouves()->avg('rating') ?? 0;
    }

    /**
     * Nombre total d'avis approuvés
     */
    public function nombreAvis()
    {
        return $this->avisApprouves()->count();
    }

    /**
     * Obtenir la répartition des notes (1-5 étoiles)
     */
    public function repartitionNotes()
    {
        return Avis::repartitionNotesEvent($this->id);
    }

    // ====== AUTO-GÉNÉRATION DU SLUG ======
    
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($event) {
            if (!$event->slug) {
                $event->slug = Str::slug($event->title);
            }
        });
    }
}
