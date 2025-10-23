@extends('layouts.app')

@section('title', 'Choisir votre rôle - EcoEvents')

@push('styles')
<style>
.role-selection-container {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 50%, #f0f9ff 100%);
    padding: 2rem;
}

.role-selection-card {
    background: white;
    border-radius: 24px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    padding: 3rem;
    max-width: 600px;
    width: 100%;
    text-align: center;
}

.role-selection-title {
    font-size: 2.5rem;
    font-weight: 900;
    color: #1f2937;
    margin-bottom: 1rem;
}

.role-selection-subtitle {
    font-size: 1.1rem;
    color: #6b7280;
    margin-bottom: 3rem;
    line-height: 1.6;
}

.roles-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
    margin-bottom: 3rem;
}

.role-card {
    border: 2px solid #e5e7eb;
    border-radius: 16px;
    padding: 2rem;
    cursor: pointer;
    transition: all 0.3s ease;
    background: white;
    position: relative;
}

.role-card:hover {
    border-color: #10b981;
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(16, 185, 129, 0.2);
}

.role-card.selected {
    border-color: #10b981;
    background: #f0fdf4;
    box-shadow: 0 15px 35px rgba(16, 185, 129, 0.3);
}

.role-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #10b981, #059669);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    font-size: 1.5rem;
    color: white;
}

.role-card h3 {
    font-size: 1.3rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 1rem;
}

.role-card p {
    color: #6b7280;
    font-size: 0.9rem;
    line-height: 1.5;
    margin-bottom: 1.5rem;
}

.role-features {
    text-align: left;
    font-size: 0.85rem;
    color: #6b7280;
}

.role-features ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.role-features li {
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.role-features i {
    color: #10b981;
    font-size: 0.8rem;
}

.btn-confirm-role {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
    border: none;
    padding: 1.2rem 3rem;
    border-radius: 12px;
    font-size: 1.1rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s ease;
    width: 100%;
    max-width: 300px;
}

.btn-confirm-role:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(16, 185, 129, 0.3);
}

.btn-confirm-role:disabled {
    background: #d1d5db;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}

.user-info {
    background: #f9fafb;
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 2rem;
    border: 1px solid #e5e7eb;
}

.user-avatar {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    margin: 0 auto 1rem;
    border: 3px solid #10b981;
}

.user-name {
    font-size: 1.2rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 0.5rem;
}

.user-email {
    color: #6b7280;
    font-size: 0.9rem;
}

@media (max-width: 768px) {
    .roles-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }

    .role-selection-card {
        padding: 2rem;
        margin: 1rem;
    }

    .role-selection-title {
        font-size: 2rem;
    }

    .role-card {
        padding: 1.5rem;
    }
}
</style>
@endpush

@section('content')
<div class="role-selection-container">
    <div class="role-selection-card">
        <div class="user-info">
            @if($user->avatar)
                <img src="{{ $user->avatar }}" alt="Avatar" class="user-avatar">
            @else
                <div class="user-avatar" style="background: linear-gradient(135deg, #10b981, #059669); display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: white;">
                    <i class="fas fa-user"></i>
                </div>
            @endif
            <h3 class="user-name">{{ $user->name }}</h3>
            <p class="user-email">{{ $user->email }}</p>
        </div>

        <h1 class="role-selection-title">Choisissez votre rôle</h1>
        <p class="role-selection-subtitle">
            Bienvenue sur EcoEvents ! Pour personnaliser votre expérience, veuillez sélectionner le rôle qui vous correspond le mieux.
        </p>

        <form id="roleForm" action="{{ route('auth.complete-oauth-registration') }}" method="POST">
            @csrf
            <input type="hidden" name="user_id" value="{{ $user->id }}">
            <input type="hidden" name="role" id="selectedRole" value="">

            <div class="roles-grid">
                <div class="role-card" data-role="participant" onclick="selectRole('participant')">
                    <div class="role-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>Participant</h3>
                    <p>Participez aux événements éco-responsables et contribuez à un avenir durable.</p>
                    <div class="role-features">
                        <ul>
                            <li><i class="fas fa-check"></i> Inscription aux événements</li>
                            <li><i class="fas fa-check"></i> Accès aux ressources</li>
                            <li><i class="fas fa-check"></i> Participation aux activités</li>
                            <li><i class="fas fa-check"></i> Suivi de l'impact écologique</li>
                        </ul>
                    </div>
                </div>

                <div class="role-card" data-role="volunteer" onclick="selectRole('volunteer')">
                    <div class="role-icon">
                        <i class="fas fa-hands-helping"></i>
                    </div>
                    <h3>Bénévole</h3>
                    <p>Impliquez-vous activement dans l'organisation d'événements durables.</p>
                    <div class="role-features">
                        <ul>
                            <li><i class="fas fa-check"></i> Toutes les fonctionnalités Participant</li>
                            <li><i class="fas fa-check"></i> Accès aux missions bénévoles</li>
                            <li><i class="fas fa-check"></i> Gestion d'équipes</li>
                            <li><i class="fas fa-check"></i> Formation et certifications</li>
                        </ul>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-confirm-role" id="confirmBtn" disabled>
                <i class="fas fa-check"></i>
                Confirmer mon choix
            </button>
        </form>
    </div>
</div>

@push('scripts')
<script>
function selectRole(role) {
    // Remove selected class from all cards
    document.querySelectorAll('.role-card').forEach(card => {
        card.classList.remove('selected');
    });

    // Add selected class to clicked card
    document.querySelector(`[data-role="${role}"]`).classList.add('selected');

    // Set the hidden input value
    document.getElementById('selectedRole').value = role;

    // Enable the confirm button
    document.getElementById('confirmBtn').disabled = false;
}

// Auto-select participant role by default
document.addEventListener('DOMContentLoaded', function() {
    selectRole('participant');
});
</script>
@endpush
@endsection