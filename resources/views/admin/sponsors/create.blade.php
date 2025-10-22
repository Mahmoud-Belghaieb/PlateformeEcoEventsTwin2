@extends('layouts.admin')

@section('title', 'Add New Sponsor')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="mb-2">
                    <i class="fas fa-handshake me-2"></i>
                    Add New Sponsor
                </h1>
                <p class="mb-0 opacity-90">Create a new sponsor partnership</p>
            </div>
            <a href="{{ route('admin.sponsors.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Sponsors
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header bg-gradient-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Sponsor Information</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.sponsors.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="name" class="form-label">Nom <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" id="description" rows="4" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="website" class="form-label">Site Web</label>
                                <input type="url" name="website" id="website" class="form-control @error('website') is-invalid @enderror" value="{{ old('website') }}" placeholder="https://example.com">
                                @error('website')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="logo" class="form-label">Logo</label>
                                <input type="file" name="logo" id="logo" class="form-control @error('logo') is-invalid @enderror" accept="image/*">
                                @error('logo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Max 2MB - jpeg, png, jpg, gif</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="contact_email" class="form-label">Email de Contact</label>
                                <input type="email" name="contact_email" id="contact_email" class="form-control @error('contact_email') is-invalid @enderror" value="{{ old('contact_email') }}">
                                @error('contact_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="contact_phone" class="form-label">Téléphone de Contact</label>
                                <input type="text" name="contact_phone" id="contact_phone" class="form-control @error('contact_phone') is-invalid @enderror" value="{{ old('contact_phone') }}">
                                @error('contact_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="sponsorship_level" class="form-label">Niveau de Sponsoring <span class="text-danger">*</span></label>
                                <select name="sponsorship_level" id="sponsorship_level" class="form-select @error('sponsorship_level') is-invalid @enderror" required>
                                    <option value="">-- Sélectionner --</option>
                                    <option value="bronze" {{ old('sponsorship_level') == 'bronze' ? 'selected' : '' }}>Bronze</option>
                                    <option value="silver" {{ old('sponsorship_level') == 'silver' ? 'selected' : '' }}>Silver</option>
                                    <option value="gold" {{ old('sponsorship_level') == 'gold' ? 'selected' : '' }}>Gold</option>
                                    <option value="platinum" {{ old('sponsorship_level') == 'platinum' ? 'selected' : '' }}>Platinum</option>
                                </select>
                                @error('sponsorship_level')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="contribution_amount" class="form-label">Montant de Contribution (DT) <span class="text-danger">*</span></label>
                                <input type="number" name="contribution_amount" id="contribution_amount" class="form-control @error('contribution_amount') is-invalid @enderror" value="{{ old('contribution_amount', 0) }}" step="0.01" min="0" required>
                                @error('contribution_amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <div class="form-check">
                                    <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                    <label for="is_active" class="form-check-label">Actif</label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.sponsors.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Retour
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Créer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
