

<form action="{{ route('update.password') }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="current_password">Mot de passe actuel</label>
        <input type="password" name="current_password" id="current_password" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="new_password">Nouveau mot de passe</label>
        <input type="password" name="new_password" id="new_password" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="new_password_confirmation">Confirmer le nouveau mot de passe</label>
        <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary">Modifier mon mot de passe</button>
</form>
