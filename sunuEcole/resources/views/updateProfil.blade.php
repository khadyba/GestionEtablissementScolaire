
<form action="{{ route('admin.profile.update') }}" method="POST">
    @csrf
    @method('PUT')

    <label for="adresse">Adresse :</label>
    <input type="text" id="adresse" name="adresse" value="{{ old('adresse', $admin->adresse) }}" required><br>

    <label for="telephone">Numéro de téléphone :</label>
    <input type="text" id="telephone" name="telephone" value="{{ old('telephone', $admin->telephone) }}" required><br>

    <label for="email">Email :</label>
    <input type="email" id="email" name="email" value="{{ old('email', $admin->email) }}" required><br>

    <button type="submit">Mettre à jour</button>
</form>
