

<form action="{{ route('administrateurs.store') }}" method="POST">
    @csrf

    <label for="nom">Nom :</label>
    <input type="text" id="nom" name="nom" required><br>

    <label for="prenoms">Prénoms :</label>
    <input type="text" id="prenoms" name="prenoms" required><br>

    <label for="adresse">Adresse :</label>
    <input type="text" id="adresse" name="adresse" required><br>

    <label for="telephone">Téléphone :</label>
    <input type="text" id="telephone" name="telephone" required><br>

    <label for="email">Email :</label>
    <input type="email" id="email" name="email" required><br>

    <label for="password">Mot de passe :</label>
    <input type="password" id="password" name="password" required><br>

    <button type="submit">Créer Administrateur</button>
</form>
