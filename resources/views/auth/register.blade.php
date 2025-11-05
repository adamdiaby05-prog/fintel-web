@extends('layouts.app')

@section('title', 'Inscription')

@section('content')
<div class="logo">
    <h1>Fintel</h1>
    <p>Créez votre compte</p>
</div>

<form method="POST" action="{{ route('register') }}">
    @csrf

    <div class="form-group">
        <label for="phone_number">Numéro de téléphone *</label>
        <input type="tel" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" required autofocus>
        @error('phone_number')
            <span class="error-message">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="email">Email (optionnel)</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}">
        @error('email')
            <span class="error-message">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="first_name">Prénom (optionnel)</label>
        <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}">
        @error('first_name')
            <span class="error-message">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="last_name">Nom (optionnel)</label>
        <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}">
        @error('last_name')
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

    <div class="checkbox-group">
        <input type="checkbox" id="terms_accepted" name="terms_accepted" value="1" required>
        <label for="terms_accepted">J'accepte les conditions d'utilisation *</label>
    </div>

    <button type="submit" class="btn">S'inscrire</button>
</form>

<div class="link">
    <p>Vous avez déjà un compte ? <a href="{{ route('login') }}">Se connecter</a></p>
    <p style="margin-top: 10px;"><a href="{{ route('admin.login') }}">Accès Administrateur</a></p>
</div>
@endsection

