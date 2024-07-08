<!-- formulaire de connection pour les utilisateurs  -->

<form method="POST" action="{{ route('users.login.submit') }}">
    @csrf

    <label for="email">Email</label>
    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>

    <label for="password">Mot de passe</label>
    <input id="password" type="password" name="password" required>

    <button type="submit">Se connecter</button>
</form>