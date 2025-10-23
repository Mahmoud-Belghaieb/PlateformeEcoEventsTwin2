@extends('layouts.admin')

@section('title', 'Create Venue')

@push('styles')
<style>
    #venueLocationMap {
        height: 400px !important;
        width: 100% !important;
        min-height: 400px !important;
        border-radius: 8px;
        border: 2px solid #e5e7eb;
        margin-bottom: 1rem;
        background-color: #f0f0f0;
        position: relative;
        display: block !important;
        visibility: visible !important;
    }

    .leaflet-container {
        height: 400px !important;
        width: 100% !important;
    }

    #venueLocationMap::before {
        content: "Loading map...";
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: #666;
        font-weight: bold;
        z-index: 1;
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

    .map-debug {
        background: #fff3cd;
        border: 1px solid #ffeaa7;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1rem;
        font-family: monospace;
        font-size: 0.85em;
    }
</style>
@endpush

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
                                {{-- Venue basic info --}}
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

                                {{-- Postal Code + Country --}}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="postal_code" class="form-label">Postal Code</label>
                                            <input type="text"
                                                   class="form-control @error('postal_code') is-invalid @enderror"
                                                   id="postal_code"
                                                   name="postal_code"
                                                   value="{{ old('postal_code') }}"
                                                   placeholder="e.g., 1000">
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
                                                <option value="">Select a country</option>
                                                <option value="Tunisia" {{ old('country') == 'Tunisia' ? 'selected' : '' }}>Tunisia</option>
                                                <option value="Algeria" {{ old('country') == 'Algeria' ? 'selected' : '' }}>Algeria</option>
                                                <option value="Morocco" {{ old('country') == 'Morocco' ? 'selected' : '' }}>Morocco</option>
                                                <option value="Libya" {{ old('country') == 'Libya' ? 'selected' : '' }}>Libya</option>
                                                <option value="Egypt" {{ old('country') == 'Egypt' ? 'selected' : '' }}>Egypt</option>
                                                <option value="France" {{ old('country') == 'France' ? 'selected' : '' }}>France</option>
                                                <option value="Italy" {{ old('country') == 'Italy' ? 'selected' : '' }}>Italy</option>
                                                <option value="Spain" {{ old('country') == 'Spain' ? 'selected' : '' }}>Spain</option>
                                                <option value="Other" {{ old('country') == 'Other' ? 'selected' : '' }}>Other</option>
                                            </select>
                                            @error('country')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- Map section --}}
                                <div class="mb-4">
                                    <h6 class="mb-3">
                                        <i class="fas fa-map-marked-alt me-2"></i>
                                        Location Coordinates
                                    </h6>

                                    <div class="map-debug">
                                        <strong>Debug Info:</strong><br>
                                        Map Container ID: venueLocationMap<br>
                                        Leaflet Status: <span id="leafletStatus">Loading...</span><br>
                                        Map Status: <span id="mapStatus">Not initialized</span>
                                    </div>

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
                                                       value="{{ old('latitude') }}"
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
                                                       value="{{ old('longitude') }}"
                                                       step="0.0000001"
                                                       placeholder="Click on map or enter manually">
                                                @error('longitude')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <small class="text-muted">
                                            <i class="fas fa-mouse-pointer me-1"></i>
                                            Click on the map to set coordinates, or edit them manually.
                                        </small>
                                    </div>
                                </div>

                                {{-- Contact info --}}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="phone" class="form-label">Phone Number</label>
                                            <input type="tel"
                                                   class="form-control @error('phone') is-invalid @enderror"
                                                   id="phone"
                                                   name="phone"
                                                   value="{{ old('phone') }}"
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
                                                   value="{{ old('email') }}">
                                            @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- Capacity + Website --}}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="capacity" class="form-label">Maximum Capacity</label>
                                            <input type="number"
                                                   class="form-control @error('capacity') is-invalid @enderror"
                                                   id="capacity"
                                                   name="capacity"
                                                   value="{{ old('capacity') }}"
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
                                                   value="{{ old('website') }}">
                                            @error('website')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- Description --}}
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

                            {{-- Right column info --}}
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('🗺️ Starting map initialization...');

    const leafletStatus = document.getElementById('leafletStatus');
    const mapStatus = document.getElementById('mapStatus');

    if (typeof L !== 'undefined') {
        console.log('✅ Leaflet is available!');
        leafletStatus.textContent = 'Loaded successfully';
        leafletStatus.style.color = 'green';
        initializeVenueMap();
    } else {
        console.error('❌ Leaflet not available');
        leafletStatus.textContent = 'Not available';
        leafletStatus.style.color = 'red';
        mapStatus.textContent = 'Leaflet not loaded';
        mapStatus.style.color = 'red';
    }
});

function initializeVenueMap() {
    const mapStatus = document.getElementById('mapStatus');

    try {
        const map = L.map('venueLocationMap').setView([36.8065, 10.1815], 8);
        mapStatus.textContent = 'Map initialized';
        mapStatus.style.color = 'green';

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors',
            maxZoom: 19
        }).addTo(map);

        const latitudeInput = document.getElementById('latitude');
        const longitudeInput = document.getElementById('longitude');
        let currentMarker = null;

        const venueIcon = L.divIcon({
            html: '<div style="background-color: #059669; width: 20px; height: 20px; border-radius: 50%; border: 3px solid white; box-shadow: 0 3px 8px rgba(0,0,0,0.3);"></div>',
            iconSize: [26, 26],
            iconAnchor: [13, 13],
            popupAnchor: [0, -13],
            className: 'venue-marker'
        });

        function addVenueMarker(lat, lng) {
            if (currentMarker) map.removeLayer(currentMarker);
            currentMarker = L.marker([lat, lng], { icon: venueIcon }).addTo(map);
            latitudeInput.value = lat.toFixed(7);
            longitudeInput.value = lng.toFixed(7);
            currentMarker.bindPopup(`<div style="text-align:center;"><strong>📍 Venue Location</strong><br>Lat: ${lat.toFixed(7)}<br>Lng: ${lng.toFixed(7)}</div>`).openPopup();
        }

        map.on('click', function(e) {
            addVenueMarker(e.latlng.lat, e.latlng.lng);
        });

        function updateMarkerFromInputs() {
            const lat = parseFloat(latitudeInput.value);
            const lng = parseFloat(longitudeInput.value);
            if (!isNaN(lat) && !isNaN(lng)) {
                addVenueMarker(lat, lng);
                map.setView([lat, lng], 15);
            }
        }

        latitudeInput.addEventListener('change', updateMarkerFromInputs);
        longitudeInput.addEventListener('change', updateMarkerFromInputs);

        // Add reference cities
        const cities = [
            { name: 'Tunis', lat: 36.8065, lng: 10.1815 },
            { name: 'Sfax', lat: 34.7406, lng: 10.7603 },
            { name: 'Sousse', lat: 35.8256, lng: 10.6411 },
            { name: 'Kairouan', lat: 35.6781, lng: 10.0963 },
            { name: 'Gabès', lat: 33.8815, lng: 10.0982 }
        ];

        cities.forEach(city => {
            L.marker([city.lat, city.lng], {
                icon: L.divIcon({
                    html: '<div style="background-color:#94a3b8;width:6px;height:6px;border-radius:50%;border:1px solid white;"></div>',
                    iconSize: [8, 8],
                    iconAnchor: [4, 4]
                })
            }).addTo(map).bindTooltip(city.name, { direction: 'top' });
        });

        setTimeout(() => map.invalidateSize(), 100);
    } catch (error) {
        console.error('❌ Error initializing map:', error);
        mapStatus.textContent = 'Error: ' + error.message;
        mapStatus.style.color = 'red';
    }
}
</script>
@endpush
