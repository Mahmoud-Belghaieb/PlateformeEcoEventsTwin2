@extends('layouts.app')

@section('title', 'Connexion par code')

@section('content')
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
      <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
          <h5 class="mb-0"><i class="fas fa-envelope-open-text me-2"></i>Recevoir un code de connexion</h5>
        </div>
        <div class="card-body">
          @if(session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
          @endif
          <form method="POST" action="{{ route('login.code.send') }}">
            @csrf
            <div class="mb-3">
              <label for="email" class="form-label">Adresse e-mail</label>
              <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required autofocus>
              @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="d-grid gap-2">
              <button type="submit" class="btn btn-primary">Envoyer le code</button>
              <a href="{{ route('login') }}" class="btn btn-outline-secondary">Se connecter avec mot de passe</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
