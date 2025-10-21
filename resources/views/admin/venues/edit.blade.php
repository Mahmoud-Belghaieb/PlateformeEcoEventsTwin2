@extends('layouts.admin')

@section('title', 'Edit Venue')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">
                        <i class="fas fa-edit me-2"></i>
                        Edit Venue: {{ $venue->name }}
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
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.venues.show', $venue) }}">{{ $venue->name }}</a>
                            </li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </nav>

                    <form action="{{ route('admin.venues.update', $venue) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
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
                                                   value="{{ old('name', $venue->name) }}" 
                                                   required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="city" class="form-label">City *</label>
                                            <input type="text" 
                                                   class="form-control @error('city') is-invalid @enderror" 
                                                   id="city" 
                                                   name="city" 
                                                   value="{{ old('city', $venue->city) }}" 
                                                   required>
                                            @error('city')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="address" class="form-label">Address *</label>
                                    <textarea class="form-control @error('address') is-invalid @enderror" 
                                              id="address" 
                                              name="address" 
                                              rows="3"
                                              required>{{ old('address', $venue->address) }}</textarea>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="postal_code" class="form-label">Postal Code *</label>
                                            <input type="text" 
                                                   class="form-control @error('postal_code') is-invalid @enderror" 
                                                   id="postal_code" 
                                                   name="postal_code" 
                                                   value="{{ old('postal_code', $venue->postal_code) }}" 
                                                   required
                                                   placeholder="Ex: 1000">
                                            @error('postal_code')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">Country</label>
                                            <select class="form-control @error('country') is-invalid @enderror" 
                                                    id="country" 
                                                    name="country">
                                                <option value="Tunisia" {{ old('country', $venue->country ?? 'Tunisia') == 'Tunisia' ? 'selected' : '' }}>Tunisia</option>
                                                <option value="France" {{ old('country', $venue->country) == 'France' ? 'selected' : '' }}>France</option>
                                                <option value="Other" {{ old('country', $venue->country) == 'Other' ? 'selected' : '' }}>Other</option>
                                            </select>
                                            @error('country')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="contact_phone" class="form-label">Contact Phone</label>
                                            <input type="tel" 
                                                   class="form-control @error('contact_phone') is-invalid @enderror" 
                                                   id="contact_phone" 
                                                   name="contact_phone" 
                                                   value="{{ old('contact_phone', $venue->contact_phone) }}"
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
                                                   value="{{ old('contact_email', $venue->contact_email) }}">
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
                                                   value="{{ old('capacity', $venue->capacity) }}"
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
                                                   value="{{ old('price_per_hour', $venue->price_per_hour) }}"
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
                                                   value="{{ old('latitude', $venue->latitude) }}"
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
                                                   value="{{ old('longitude', $venue->longitude) }}"
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
                                        @php
                                            $currentFacilities = old('facilities', $venue->facilities ?? []);
                                            if (is_string($currentFacilities)) {
                                                $currentFacilities = json_decode($currentFacilities, true) ?? [];
                                            }
                                        @endphp
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="facilities[]" value="parking" id="facility_parking" 
                                                       {{ in_array('parking', $currentFacilities) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="facility_parking">
                                                    <i class="fas fa-car me-1"></i> Parking
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="facilities[]" value="wifi" id="facility_wifi"
                                                       {{ in_array('wifi', $currentFacilities) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="facility_wifi">
                                                    <i class="fas fa-wifi me-1"></i> WiFi
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="facilities[]" value="air_conditioning" id="facility_ac"
                                                       {{ in_array('air_conditioning', $currentFacilities) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="facility_ac">
                                                    <i class="fas fa-snowflake me-1"></i> Air Conditioning
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="facilities[]" value="sound_system" id="facility_sound"
                                                       {{ in_array('sound_system', $currentFacilities) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="facility_sound">
                                                    <i class="fas fa-volume-up me-1"></i> Sound System
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="facilities[]" value="catering" id="facility_catering"
                                                       {{ in_array('catering', $currentFacilities) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="facility_catering">
                                                    <i class="fas fa-utensils me-1"></i> Catering
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="facilities[]" value="accessibility" id="facility_accessibility"
                                                       {{ in_array('accessibility', $currentFacilities) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="facility_accessibility">
                                                    <i class="fas fa-wheelchair me-1"></i> Accessibility
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" 
                                               {{ old('is_active', $venue->is_active) ? 'checked' : '' }}>
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
                                              placeholder="Enter venue description, facilities, and any special notes...">{{ old('description', $venue->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title">
                                            <i class="fas fa-chart-bar me-1"></i>
                                            Venue Statistics
                                        </h6>
                                        <div class="row text-center">
                                            <div class="col-6">
                                                <div class="border-end">
                                                    <h4 class="text-primary-green mb-0">{{ $venue->events()->count() }}</h4>
                                                    <small class="text-muted">Events</small>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <h4 class="text-accent-orange mb-0">{{ $venue->capacity ?? 'N/A' }}</h4>
                                                <small class="text-muted">Capacity</small>
                                            </div>
                                        </div>
                                        <hr>
                                    
                                    </div>
                                </div>

                                @if($venue->events()->count() > 0)
                                <div class="card bg-info bg-opacity-10 mt-3">
                                    <div class="card-body">
                                        <h6 class="card-title text-info">
                                            <i class="fas fa-exclamation-triangle me-1"></i>
                                            Notice
                                        </h6>
                                        <p class="card-text small mb-0">
                                            This venue has {{ $venue->events()->count() }} events associated with it. 
                                            Changes may affect event details.
                                        </p>
                                    </div>
                                </div>
                                @endif

                                <div class="card bg-success bg-opacity-10 mt-3">
                                    <div class="card-body">
                                        <h6 class="card-title text-success">
                                            <i class="fas fa-map-marker-alt me-1"></i>
                                            Current Location
                                        </h6>
                                        <p class="card-text small mb-0">
                                            <strong>{{ $venue->city }}</strong><br>
                                            {{ $venue->address }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>
                        
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <a href="{{ route('admin.venues.index') }}" class="btn btn-secondary me-2">
                                            <i class="fas fa-arrow-left me-1"></i>
                                            Back to Venues
                                        </a>
                                        <a href="{{ route('admin.venues.show', $venue) }}" class="btn btn-outline-info">
                                            <i class="fas fa-eye me-1"></i>
                                            View Venue
                                        </a>
                                    </div>
                                    <button type="submit" class="btn btn-warning">
                                        <i class="fas fa-save me-1"></i>
                                        Update Venue
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