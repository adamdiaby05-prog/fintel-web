@extends('layouts.app')

@section('title', 'Connexion Admin')

@section('content')
<div class="logo">
    <h1>Fintel</h1>
    <p>Interface Administrateur</p>
</div>

<form method="POST" action="{{ route('admin.login') }}">
    @csrf

    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
        @error('email')
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
    <p>Vous n'avez pas de compte ? <a href="{{ route('admin.register') }}">Créer un compte admin</a></p>
    <p style="margin-top: 10px;"><a href="{{ route('login') }}">Retour à l'interface utilisateur</a></p>
</div>
@endsection

