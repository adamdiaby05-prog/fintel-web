@extends('layouts.app')

@section('title', 'Inscription Admin')

@section('content')
<div class="logo">
    <h1>Fintel</h1>
    <p>Créez un compte administrateur</p>
</div>

<form method="POST" action="{{ route('admin.register') }}">
    @csrf

    <div class="form-group">
        <label for="first_name">Prénom *</label>
        <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" required autofocus>
        @error('first_name')
            <span class="error-message">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="last_name">Nom *</label>
        <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" required>
        @error('last_name')
            <span class="error-message">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="email">Email *</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required>
        @error('email')
            <span class="error-message">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="password">Mot de passe *</label>
        <input type="password" id="password" name="password" required>
        @error('password')
            <span class="error-message">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="password_confirmation">Confirmer le mot de passe *</label>
        <input type="password" id="password_confirmation" name="password_confirmation" required>
        @error('password_confirmation')
            <span class="error-message">{{ $message }}</span>
        @enderror
    </div>

    <button type="submit" class="btn">Créer le compte</button>
</form>

<div class="link">
    <p>Vous avez déjà un compte ? <a href="{{ route('admin.login') }}">Se connecter</a></p>
</div>
@endsection

