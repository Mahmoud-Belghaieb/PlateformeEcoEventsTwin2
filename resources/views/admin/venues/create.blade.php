@extends('layouts.admin')

@section('title', 'Create Venue')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary-green text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-plus me-2"></i>
                        Create New Venue
                    </h5>
                </div>
                <div class="card-body">
                    <nav aria-label="breadcrumb" class="mb-4">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.venues.index') }}">Venues</a>
                            </li>
                            <li class="breadcrumb-item active">Create</li>
                        </ol>
                    </nav>

                    <form action="{{ route('admin.venues.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Venue Name *</label>
                                            <input type="text" 
                                                   class="form-control @error('name') is-invalid @enderror" 
                                                   id="name" 
                                                   name="name" 
                                                   value="{{ old('name') }}" 
                                                   required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                                                    <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="city" class="form-label">City *</label>
                                            <input type="text" 
                                                   class="form-control @error('city') is-invalid @enderror" 
                                                   id="city" 
                                                   name="city" 
                                                   value="{{ old('city') }}" 
                                                   required>
                                            @error('city')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="postal_code" class="form-label">Postal Code *</label>
                                            <input type="text" 
                                                   class="form-control @error('postal_code') is-invalid @enderror" 
                                                   id="postal_code" 
                                                   name="postal_code" 
                                                   value="{{ old('postal_code') }}" 
                                                   required
                                                   placeholder="Ex: 1000">
                                            @error('postal_code')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                </div>

                                <div class="mb-3">
                                    <label for="address" class="form-label">Address *</label>
                                    <textarea class="form-control @error('address') is-invalid @enderror" 
                                              id="address" 
                                              name="address" 
                                              rows="3"
                                              required>{{ old('address') }}</textarea>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="country" class="form-label">Country</label>
                                    <select class="form-control @error('country') is-invalid @enderror" 
                                            id="country" 
                                            name="country">
                                        <option value="Tunisia" {{ old('country', 'Tunisia') == 'Tunisia' ? 'selected' : '' }}>Tunisia</option>
                                        <option value="France" {{ old('country') == 'France' ? 'selected' : '' }}>France</option>
                                        <option value="Other" {{ old('country') == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('country')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="contact_phone" class="form-label">Contact Phone</label>
                                            <input type="tel" 
                                                   class="form-control @error('contact_phone') is-invalid @enderror" 
                                                   id="contact_phone" 
                                                   name="contact_phone" 
                                                   value="{{ old('contact_phone') }}"
                                                   placeholder="+216 XX XXX XXX">
                                            @error('contact_phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="contact_email" class="form-label">Contact Email</label>
                                            <input type="email" 
                                                   class="form-control @error('contact_email') is-invalid @enderror" 
                                                   id="contact_email" 
                                                   name="contact_email" 
                                                   value="{{ old('contact_email') }}">
                                            @error('contact_email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="capacity" class="form-label">Maximum Capacity *</label>
                                            <input type="number" 
                                                   class="form-control @error('capacity') is-invalid @enderror" 
                                                   id="capacity" 
                                                   name="capacity" 
                                                   value="{{ old('capacity') }}"
                                                   min="1"
                                                   required>
                                            @error('capacity')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="price_per_hour" class="form-label">Price per Hour (TND)</label>
                                            <input type="number" 
                                                   class="form-control @error('price_per_hour') is-invalid @enderror" 
                                                   id="price_per_hour" 
                                                   name="price_per_hour" 
                                                   value="{{ old('price_per_hour') }}"
                                                   min="0"
                                                   step="0.01"
                                                   placeholder="0.00">
                                            @error('price_per_hour')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="latitude" class="form-label">Latitude</label>
                                            <input type="number" 
                                                   class="form-control @error('latitude') is-invalid @enderror" 
                                                   id="latitude" 
                                                   name="latitude" 
                                                   value="{{ old('latitude') }}"
                                                   step="0.0000001"
                                                   placeholder="Ex: 36.8065">
                                            @error('latitude')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="longitude" class="form-label">Longitude</label>
                                            <input type="number" 
                                                   class="form-control @error('longitude') is-invalid @enderror" 
                                                   id="longitude" 
                                                   name="longitude" 
                                                   value="{{ old('longitude') }}"
                                                   step="0.0000001"
                                                   placeholder="Ex: 10.1815">
                                            @error('longitude')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="facilities" class="form-label">Facilities</label>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="facilities[]" value="parking" id="facility_parking">
                                                <label class="form-check-label" for="facility_parking">
                                                    <i class="fas fa-car me-1"></i> Parking
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="facilities[]" value="wifi" id="facility_wifi">
                                                <label class="form-check-label" for="facility_wifi">
                                                    <i class="fas fa-wifi me-1"></i> WiFi
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="facilities[]" value="air_conditioning" id="facility_ac">
                                                <label class="form-check-label" for="facility_ac">
                                                    <i class="fas fa-snowflake me-1"></i> Air Conditioning
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="facilities[]" value="sound_system" id="facility_sound">
                                                <label class="form-check-label" for="facility_sound">
                                                    <i class="fas fa-volume-up me-1"></i> Sound System
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="facilities[]" value="catering" id="facility_catering">
                                                <label class="form-check-label" for="facility_catering">
                                                    <i class="fas fa-utensils me-1"></i> Catering
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="facilities[]" value="accessibility" id="facility_accessibility">
                                                <label class="form-check-label" for="facility_accessibility">
                                                    <i class="fas fa-wheelchair me-1"></i> Accessibility
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" checked>
                                        <label class="form-check-label" for="is_active">
                                            <i class="fas fa-check-circle me-1"></i>
                                            Venue is Active
                                        </label>
                                    </div>
                                    <small class="form-text text-muted">Uncheck to make this venue unavailable for new events</small>
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" 
                                              name="description" 
                                              rows="4"
                                              placeholder="Enter venue description, facilities, and any special notes...">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Venue Information
                                        </h6>
                                        <p class="card-text small text-muted">
                                            Venues are locations where events take place. Provide accurate contact information and capacity details.
                                        </p>
                                        <p class="card-text small">
                                            <strong>Tunisia Examples:</strong><br>
                                            • Parc Ichkeul, Bizerte<br>
                                            • Marina de la Marsa, Tunis<br>
                                            • Centre Culturel International, Hammamet<br>
                                            • Parc Belvédère, Tunis<br>
                                            • Amphithéâtre El Jem, Mahdia
                                        </p>
                                    </div>
                                </div>

                                <div class="card bg-success bg-opacity-10 mt-3">
                                    <div class="card-body">
                                        <h6 class="card-title text-success">
                                            <i class="fas fa-phone me-1"></i>
                                            Tunisian Phone Format
                                        </h6>
                                        <p class="card-text small mb-0">
                                            Use Tunisian phone format:<br>
                                            <strong>+216 XX XXX XXX</strong><br>
                                            Example: +216 71 123 456
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>
                        
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('admin.venues.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left me-1"></i>
                                        Back to Venues
                                    </a>
                                    <button type="submit" class="btn btn-primary-green">
                                        <i class="fas fa-save me-1"></i>
                                        Create Venue
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection