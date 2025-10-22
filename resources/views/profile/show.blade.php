@extends('layouts.app')

@section('title', 'Mon Profil - EcoEvents')

@push('styles')
<style>
.profile-container {
    min-height: 100vh;
    background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 50%, #f0f9ff 100%);
    padding: 2rem 0;
}

.profile-card {
    background: white;
    border-radius: 24px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    padding: 3rem;
    max-width: 800px;
    margin: 0 auto;
}

.profile-header {
    text-align: center;
    margin-bottom: 3rem;
}

.profile-avatar {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    margin: 0 auto 1.5rem;
    border: 4px solid #10b981;
    object-fit: cover;
}

.profile-name {
    font-size: 2rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 0.5rem;
}

.profile-email {
    color: #6b7280;
    font-size: 1.1rem;
}

.profile-section {
    margin-bottom: 3rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid #e5e7eb;
}

.profile-section:last-child {
    border-bottom: none;
    margin-bottom: 0;
    padding-bottom: 0;
}

.section-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.section-title i {
    color: #10b981;
}

.role-info {
    background: #f9fafb;
    border-radius: 12px;
    padding: 2rem;
    border: 1px solid #e5e7eb;
}

.current-role {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 600;
}

.role-description {
    margin-top: 1rem;
    color: #6b7280;
    line-height: 1.6;
}

.role-update-form {
    margin-top: 2rem;
}

.role-options {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.role-option {
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    padding: 1.5rem;
    cursor: pointer;
    transition: all 0.3s ease;
    background: white;
}

.role-option:hover {
    border-color: #10b981;
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(16, 185, 129, 0.1);
}

.role-option.selected {
    border-color: #10b981;
    background: #f0fdf4;
}

.role-option-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1rem;
}

.role-option-icon {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #10b981, #059669);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.1rem;
}

.role-option h4 {
    font-size: 1.1rem;
    font-weight: 700;
    color: #1f2937;
    margin: 0;
}

.role-option p {
    color: #6b7280;
    font-size: 0.9rem;
    line-height: 1.5;
    margin: 0;
}

.btn-update-role {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
    border: none;
    padding: 1rem 2rem;
    border-radius: 12px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    width: 100%;
    max-width: 300px;
    margin: 0 auto;
    display: block;
}

.btn-update-role:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(16, 185, 129, 0.3);
}

.btn-update-role:disabled {
    background: #d1d5db;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}

.account-info {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
}

.info-item {
    background: #f9fafb;
    border-radius: 12px;
    padding: 1.5rem;
    border: 1px solid #e5e7eb;
}

.info-label {
    font-size: 0.9rem;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 0.5rem;
}

.info-value {
    font-size: 1.1rem;
    color: #1f2937;
    font-weight: 500;
}

@media (max-width: 768px) {
    .profile-card {
        margin: 1rem;
        padding: 2rem;
    }

    .role-options {
        grid-template-columns: 1fr;
    }

    .account-info {
        grid-template-columns: 1fr;
    }

    .profile-name {
        font-size: 1.5rem;
    }

    .profile-avatar {
        width: 100px;
        height: 100px;
    }
}
</style>
@endpush

@section('content')
<div class="profile-container">
    <div class="profile-card">
        <!-- Profile Header -->
        <div class="profile-header">
            @if(Auth::user()->avatar)
                <img src="{{ Auth::user()->avatar }}" alt="Avatar" class="profile-avatar">
            @else
                <div class="profile-avatar" style="background: linear-gradient(135deg, #10b981, #059669); display: flex; align-items: center; justify-content: center; font-size: 2.5rem; color: white;">
                    <i class="fas fa-user"></i>
                </div>
            @endif
            <h1 class="profile-name">{{ Auth::user()->name }}</h1>
            <p class="profile-email">{{ Auth::user()->email }}</p>
        </div>

        <!-- Role Information -->
        <div class="profile-section">
            <h2 class="section-title">
                <i class="fas fa-user-tag"></i>
                Rôle et Permissions
            </h2>

            <div class="role-info">
                <div style="margin-bottom: 1rem;">
                    <span class="current-role">
                        <i class="fas fa-crown"></i>
                        {{ Auth::user()->getRoleDisplayName() }}
                    </span>
                </div>

                <div class="role-description">
                    @if(Auth::user()->isAdmin())
                        <p>En tant qu'administrateur, vous avez accès à toutes les fonctionnalités de gestion de la plateforme, y compris la gestion des utilisateurs, événements, et paramètres système.</p>
                    @elseif(Auth::user()->isParticipant())
                        <p>En tant que participant, vous pouvez vous inscrire aux événements, laisser des avis, et accéder aux ressources communautaires.</p>
                    @elseif(Auth::user()->isVolunteer())
                        <p>En tant que bénévole, vous pouvez participer à l'organisation d'événements, gérer des équipes, et accéder à des formations spécialisées.</p>
                    @else
                        <p>Votre rôle n'est pas encore défini. Veuillez sélectionner un rôle ci-dessous pour accéder à toutes les fonctionnalités.</p>
                    @endif
                </div>

                <!-- Role Update Form -->
                <form class="role-update-form" id="roleUpdateForm" action="{{ route('profile.update-role') }}" method="POST">
                    @csrf
                    <input type="hidden" name="role" id="selectedRoleInput" value="{{ Auth::user()->role }}">

                    <div class="role-options">
                        <div class="role-option {{ Auth::user()->role === 'participant' ? 'selected' : '' }}" data-role="participant" onclick="selectRole('participant')">
                            <div class="role-option-header">
                                <div class="role-option-icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <h4>Participant</h4>
                            </div>
                            <p>Participez aux événements éco-responsables et contribuez à un avenir durable.</p>
                        </div>

                        <div class="role-option {{ Auth::user()->role === 'volunteer' ? 'selected' : '' }}" data-role="volunteer" onclick="selectRole('volunteer')">
                            <div class="role-option-header">
                                <div class="role-option-icon">
                                    <i class="fas fa-hands-helping"></i>
                                </div>
                                <h4>Bénévole</h4>
                            </div>
                            <p>Impliquez-vous activement dans l'organisation d'événements durables.</p>
                        </div>
                    </div>

                    <button type="submit" class="btn-update-role" id="updateRoleBtn" {{ Auth::user()->role ? '' : 'disabled' }}>
                        <i class="fas fa-save"></i>
                        Mettre à jour mon rôle
                    </button>
                </form>
            </div>
        </div>

        <!-- Account Information -->
        <div class="profile-section">
            <h2 class="section-title">
                <i class="fas fa-info-circle"></i>
                Informations du compte
            </h2>

            <div class="account-info">
                <div class="info-item">
                    <div class="info-label">Membre depuis</div>
                    <div class="info-value">{{ Auth::user()->created_at->format('d/m/Y') }}</div>
                </div>

                <div class="info-item">
                    <div class="info-label">Dernière connexion</div>
                    <div class="info-value">
                        @if(Auth::user()->last_login_at)
                            {{ Auth::user()->last_login_at->format('d/m/Y H:i') }}
                        @else
                            Jamais
                        @endif
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-label">Statut du compte</div>
                    <div class="info-value">
                        <span style="color: {{ Auth::user()->is_active ? '#10b981' : '#ef4444' }};">
                            <i class="fas fa-{{ Auth::user()->is_active ? 'check-circle' : 'times-circle' }}"></i>
                            {{ Auth::user()->is_active ? 'Actif' : 'Désactivé' }}
                        </span>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-label">Connexion via</div>
                    <div class="info-value">
                        @if(Auth::user()->google_id)
                            <i class="fab fa-google" style="color: #ea4335;"></i> Google
                        @elseif(Auth::user()->facebook_id)
                            <i class="fab fa-facebook" style="color: #1877f2;"></i> Facebook
                        @elseif(Auth::user()->twitter_id)
                            <i class="fab fa-twitter" style="color: #1da1f2;"></i> Twitter
                        @elseif(Auth::user()->linkedin_id)
                            <i class="fab fa-linkedin" style="color: #0077b5;"></i> LinkedIn
                        @elseif(Auth::user()->github_id)
                            <i class="fab fa-github" style="color: #333;"></i> GitHub
                        @else
                            <i class="fas fa-envelope"></i> Email
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function selectRole(role) {
    // Remove selected class from all options
    document.querySelectorAll('.role-option').forEach(option => {
        option.classList.remove('selected');
    });

    // Add selected class to clicked option
    document.querySelector(`[data-role="${role}"]`).classList.add('selected');

    // Update hidden input
    document.getElementById('selectedRoleInput').value = role;

    // Enable update button
    document.getElementById('updateRoleBtn').disabled = false;
}

// Auto-select current role
document.addEventListener('DOMContentLoaded', function() {
    const currentRole = '{{ Auth::user()->role }}';
    if (currentRole) {
        selectRole(currentRole);
    }
});
</script>
@endpush
@endsection