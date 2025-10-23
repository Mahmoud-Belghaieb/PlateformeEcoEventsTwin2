@extends('layouts.app')

@section('title', 'Vérifier le code')

@section('content')
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
      <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
          <h5 class="mb-0"><i class="fas fa-key me-2"></i>Vérifier le code de connexion</h5>
        </div>
        <div class="card-body">
          @if(session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
          @endif
          <form method="POST" action="{{ route('login.verify.submit') }}">
            @csrf
            <div class="mb-3">
              <label class="form-label">Adresse e-mail</label>
              <input type="email" name="email" value="{{ old('email', $email) }}" class="form-control @error('email') is-invalid @enderror" required>
              @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3">
              <label class="form-label">Code de vérification</label>
              <input type="text" name="code" maxlength="6" class="form-control @error('code') is-invalid @enderror" placeholder="6 chiffres" required>
              @error('code')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="d-grid gap-2">
              <button type="submit" class="btn btn-primary">Se connecter</button>
              <form method="POST" action="{{ route('login.verify.resend') }}" style="margin-top: 10px;">
                @csrf
                <button type="submit" class="btn btn-outline-secondary w-100">Renvoyer un code</button>
              </form>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
