<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
        'last_login_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'last_login_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    // ====== RELATIONS AVEC EVENTS VIA REGISTRATIONS ======

    /**
     * Relation Many-to-Many avec Events via registrations
     */
    public function events()
    {
        return $this->belongsToMany(Event::class, 'registrations')
                    ->withPivot('type', 'position_id', 'status', 'motivation', 'additional_info',
                               'registered_at', 'approved_at', 'approved_by', 'rejection_reason',
                               'attended', 'rating', 'feedback')
                    ->withTimestamps();
    }

    /**
     * Toutes les inscriptions de l'utilisateur
     */
    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    /**
     * Événements où l'utilisateur est participant
     */
    public function participatedEvents()
    {
        return $this->belongsToMany(Event::class, 'registrations')
                    ->wherePivot('type', 'participant')
                    ->withPivot('status', 'registered_at', 'attended', 'rating', 'feedback')
                    ->withTimestamps();
    }

    /**
     * Événements où l'utilisateur est bénévole
     */
    public function volunteeredEvents()
    {
        return $this->belongsToMany(Event::class, 'registrations')
                    ->wherePivot('type', 'volunteer')
                    ->withPivot('position_id', 'status', 'motivation', 'registered_at')
                    ->withTimestamps();
    }

    /**
     * Événements créés par l'utilisateur
     */
    public function createdEvents()
    {
        return $this->hasMany(Event::class, 'created_by');
    }

    /**
     * Inscriptions approuvées par cet utilisateur (admin)
     */
    public function approvedRegistrations()
    {
        return $this->hasMany(Registration::class, 'approved_by');
    }

    /**
     * Relation avec les avis créés
     */
    public function avis()
    {
        return $this->hasMany(Avis::class);
    }

    /**
     * Relation avec les commentaires créés
     */
    public function commentaires()
    {
        return $this->hasMany(Commentaire::class);
    }

    /**
     * Relation avec les avis approuvés par cet utilisateur (admin)
     */
    public function avisApprouves()
    {
        return $this->hasMany(Avis::class, 'approved_by');
    }

    /**
     * Relation avec les commentaires approuvés par cet utilisateur (admin)
     */
    public function commentairesApprouves()
    {
        return $this->hasMany(Commentaire::class, 'approved_by');
    }

    /**
     * Relation avec le panier (shopping cart)
     */
    public function paniers()
    {
        return $this->hasMany(Panier::class);
    }

    /**
     * Get active cart items
     */
    public function activePaniers()
    {
        return $this->hasMany(Panier::class)->where('status', 'pending');
    }

    // ====== MÉTHODES UTILES ======

    /**
     * Vérifie si l'utilisateur est inscrit à un événement
     */
    public function isRegisteredTo($eventId)
    {
        return $this->registrations()->where('event_id', $eventId)->exists();
    }

    /**
     * Obtient l'inscription de l'utilisateur pour un événement
     */
    public function getRegistrationFor($eventId)
    {
        return $this->registrations()->where('event_id', $eventId)->first();
    }

    /**
     * Check if the user has admin role
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if the user has participant role
     */
    public function isParticipant(): bool
    {
        return $this->role === 'participant';
    }

    /**
     * Check if the user has volunteer role
     */
    public function isVolunteer(): bool
    {
        return $this->role === 'volunteer';
    }

    /**
     * Get role display name
     */
    public function getRoleDisplayName(): string
    {
        return match($this->role) {
            'admin' => 'Administrateur',
            'participant' => 'Participant',
            'volunteer' => 'Bénévole',
            default => 'Utilisateur'
        };
    }

    /**
     * Scope to get users by role
     */
    public function scopeWithRole($query, $role)
    {
        return $query->where('role', $role);
    }

    /**
     * Scope to get active users
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
