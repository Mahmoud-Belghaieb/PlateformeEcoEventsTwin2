@extends('layouts.admin')

@section('title', 'Edit Material')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="mb-2">
                    <i class="fas fa-edit me-2"></i>
                    Edit Material
                </h1>
                <p class="mb-0 opacity-90">Update material information: <strong>{{ $materiel->name }}</strong></p>
            </div>
            <a href="{{ route('admin.materiels.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Materials
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header bg-gradient-warning text-white">
                    <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Material Information</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.materiels.update', $materiel) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="name" class="form-label">Nom <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $materiel->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" id="description" rows="4" class="form-control @error('description') is-invalid @enderror">{{ old('description', $materiel->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="type" class="form-label">Type <span class="text-danger">*</span></label>
                                <input type="text" name="type" id="type" class="form-control @error('type') is-invalid @enderror" value="{{ old('type', $materiel->type) }}" required>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="image" class="form-label">Image</label>
                                @if($materiel->image)
                                    <div class="mb-2">
                                        <img src="{{ Storage::url($materiel->image) }}" alt="{{ $materiel->name }}" style="height: 80px;">
                                    </div>
                                @endif
                                <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Laisser vide pour garder l'image actuelle.</small>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="quantity" class="form-label">Quantité <span class="text-danger">*</span></label>
                                <input type="number" name="quantity" id="quantity" class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity', $materiel->quantity) }}" min="0" required>
                                @error('quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="condition" class="form-label">État <span class="text-danger">*</span></label>
                                <select name="condition" id="condition" class="form-select @error('condition') is-invalid @enderror" required>
                                    <option value="">-- Sélectionner --</option>
                                    <option value="good" {{ old('condition', $materiel->condition) == 'good' ? 'selected' : '' }}>Bon</option>
                                    <option value="fair" {{ old('condition', $materiel->condition) == 'fair' ? 'selected' : '' }}>Correct</option>
                                    <option value="poor" {{ old('condition', $materiel->condition) == 'poor' ? 'selected' : '' }}>Mauvais</option>
                                </select>
                                @error('condition')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="value" class="form-label">Valeur (DT) <span class="text-danger">*</span></label>
                                <input type="number" name="value" id="value" class="form-control @error('value') is-invalid @enderror" value="{{ old('value', $materiel->value) }}" step="0.01" min="0" required>
                                @error('value')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="event_id" class="form-label">Événement</label>
                                <select name="event_id" id="event_id" class="form-select @error('event_id') is-invalid @enderror">
                                    <option value="">-- Aucun --</option>
                                    @foreach($events as $event)
                                        <option value="{{ $event->id }}" {{ old('event_id', $materiel->event_id) == $event->id ? 'selected' : '' }}>
                                            {{ $event->title }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('event_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <div class="form-check">
                                    <input type="checkbox" name="is_available" id="is_available" class="form-check-input" value="1" {{ old('is_available', $materiel->is_available) ? 'checked' : '' }}>
                                    <label for="is_available" class="form-check-label">Disponible</label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.materiels.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Retour
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Mettre à jour
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
