@extends('layouts.app')

@section('title', 'Connexion')

@section('content')
<div class="logo">
    <h1>Fintel</h1>
    <p>Connectez-vous à votre compte</p>
</div>

<form method="POST" action="{{ route('login') }}">
    @csrf

    <div class="form-group">
        <label for="phone_number">Numéro de téléphone</label>
        <input type="tel" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" required autofocus>
        @error('phone_number')
            <span class="error-message">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="password">Mot de passe</label>
        <input type="password" id="password" name="password" required>
        @error('password')
            <span class="error-message">{{ $message }}</span>
        @enderror
    </div>

    <button type="submit" class="btn">Se connecter</button>
</form>

<div class="link">
    <p>Vous n'avez pas de compte ? <a href="{{ route('register') }}">S'inscrire</a></p>
    <p style="margin-top: 10px;"><a href="{{ route('admin.login') }}">Accès Administrateur</a></p>
</div>
@endsection

