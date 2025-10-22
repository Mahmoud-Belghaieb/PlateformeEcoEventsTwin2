@extends('layouts.admin')

@section('title', 'Edit Venue')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<style>
    #venueLocationMap {
        height: 400px;
        width: 100%;
        border-radius: 8px;
        border: 2px solid #e5e7eb;
        margin-bottom: 1rem;
    }
    
    .coordinates-display {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 1rem;
        margin-top: 1rem;
    }
    
    .coordinate-input {
        background-color: #f8f9fa;
        border: 1px solid #ced4da;
        border-radius: 0.375rem;
        color: #495057;
    }
    
    .map-instructions {
        background: #e3f2fd;
        border: 1px solid #bbdefb;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1rem;
    }
</style>
@endpush

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

                                <!-- Location Section -->
                                <div class="mb-4">
                                    <h6 class="mb-3">
                                        <i class="fas fa-map-marked-alt me-2"></i>
                                        Location Coordinates
                                    </h6>
                                    
                                    <div class="map-instructions">
                                        <i class="fas fa-info-circle me-2"></i>
                                        <strong>Instructions:</strong> Click on the map to set the venue location. The coordinates will be automatically filled.
                                    </div>
                                    
                                    <div id="venueLocationMap"></div>
                                    
                                    <div class="coordinates-display">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="latitude" class="form-label">Latitude</label>
                                                <input type="number" 
                                                       class="form-control coordinate-input @error('latitude') is-invalid @enderror" 
                                                       id="latitude" 
                                                       name="latitude" 
                                                       value="{{ old('latitude', $venue->latitude) }}"
                                                       step="0.0000001"
                                                       placeholder="Click on map or enter manually">
                                                @error('latitude')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label for="longitude" class="form-label">Longitude</label>
                                                <input type="number" 
                                                       class="form-control coordinate-input @error('longitude') is-invalid @enderror" 
                                                       id="longitude" 
                                                       name="longitude" 
                                                       value="{{ old('longitude', $venue->longitude) }}"
                                                       step="0.0000001"
                                                       placeholder="Click on map or enter manually">
                                                @error('longitude')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <small class="text-muted">
                                            <i class="fas fa-mouse-pointer me-1"></i>
                                            Click on the map to set coordinates, or you can manually edit these fields if needed.
                                        </small>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="phone" class="form-label">Phone Number</label>
                                            <input type="tel" 
                                                   class="form-control @error('phone') is-invalid @enderror" 
                                                   id="phone" 
                                                   name="phone" 
                                                   value="{{ old('phone', $venue->phone) }}"
                                                   placeholder="+216 XX XXX XXX">
                                            @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email Address</label>
                                            <input type="email" 
                                                   class="form-control @error('email') is-invalid @enderror" 
                                                   id="email" 
                                                   name="email" 
                                                   value="{{ old('email', $venue->email) }}">
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="capacity" class="form-label">Maximum Capacity</label>
                                            <input type="number" 
                                                   class="form-control @error('capacity') is-invalid @enderror" 
                                                   id="capacity" 
                                                   name="capacity" 
                                                   value="{{ old('capacity', $venue->capacity) }}"
                                                   min="1">
                                            @error('capacity')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="website" class="form-label">Website URL</label>
                                            <input type="url" 
                                                   class="form-control @error('website') is-invalid @enderror" 
                                                   id="website" 
                                                   name="website" 
                                                   value="{{ old('website', $venue->website) }}">
                                            @error('website')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
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

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize map centered on Tunisia
    const map = L.map('venueLocationMap').setView([33.8869, 9.5375], 7);

    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Get input fields
    const latitudeInput = document.getElementById('latitude');
    const longitudeInput = document.getElementById('longitude');

    // Variable to store the current marker
    let currentMarker = null;

    // Custom marker icon
    const customIcon = L.divIcon({
        html: '<div style="background-color: #f59e0b; width: 20px; height: 20px; border-radius: 50%; border: 3px solid white; box-shadow: 0 3px 8px rgba(0,0,0,0.3);"></div>',
        iconSize: [26, 26],
        iconAnchor: [13, 13],
        popupAnchor: [0, -13],
        className: 'venue-location-marker'
    });

    // Function to add/update marker
    function addMarker(lat, lng) {
        // Remove existing marker if any
        if (currentMarker) {
            map.removeLayer(currentMarker);
        }

        // Add new marker
        currentMarker = L.marker([lat, lng], { icon: customIcon }).addTo(map);
        
        // Update input fields
        latitudeInput.value = lat.toFixed(7);
        longitudeInput.value = lng.toFixed(7);

        // Add popup to marker
        currentMarker.bindPopup(`
            <div style="font-family: Arial, sans-serif;">
                <strong>{{ addslashes($venue->name) }}</strong><br>
                Latitude: ${lat.toFixed(7)}<br>
                Longitude: ${lng.toFixed(7)}
            </div>
        `).openPopup();
    }

    // Map click event
    map.on('click', function(e) {
        const lat = e.latlng.lat;
        const lng = e.latlng.lng;
        addMarker(lat, lng);
    });

    // Input field change events (for manual entry)
    function updateMarkerFromInputs() {
        const lat = parseFloat(latitudeInput.value);
        const lng = parseFloat(longitudeInput.value);

        if (!isNaN(lat) && !isNaN(lng) && lat >= -90 && lat <= 90 && lng >= -180 && lng <= 180) {
            addMarker(lat, lng);
            map.setView([lat, lng], 15); // Zoom to the location
        }
    }

    latitudeInput.addEventListener('change', updateMarkerFromInputs);
    longitudeInput.addEventListener('change', updateMarkerFromInputs);

    // Load existing coordinates if available
    const existingLat = latitudeInput.value;
    const existingLng = longitudeInput.value;
    
    if (existingLat && existingLng) {
        const lat = parseFloat(existingLat);
        const lng = parseFloat(existingLng);
        if (!isNaN(lat) && !isNaN(lng)) {
            addMarker(lat, lng);
            map.setView([lat, lng], 15);
        }
    }

    // Add some popular Tunisia locations as reference
    const tunisiaLocations = [
        { name: 'Tunis Centre', lat: 36.8065, lng: 10.1815 },
        { name: 'Carthage', lat: 36.8570, lng: 10.3314 },
        { name: 'Sidi Bou Said', lat: 36.8705, lng: 10.3500 },
        { name: 'Hammamet', lat: 36.4000, lng: 10.6167 },
        { name: 'Sousse', lat: 35.8256, lng: 10.6411 }
    ];

    // Add reference markers (smaller and lighter)
    tunisiaLocations.forEach(location => {
        const referenceIcon = L.divIcon({
            html: '<div style="background-color: #e0e0e0; width: 8px; height: 8px; border-radius: 50%; border: 1px solid #999;"></div>',
            iconSize: [10, 10],
            iconAnchor: [5, 5],
            className: 'reference-marker'
        });

        L.marker([location.lat, location.lng], { icon: referenceIcon })
            .addTo(map)
            .bindTooltip(location.name, { permanent: false, direction: 'top' });
    });
});
</script>
@endpush