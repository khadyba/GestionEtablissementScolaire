<form action="{{ route('etablissements.store') }}" method="POST">
    @csrf

    <label for="nom">Nom :</label>
    <input type="text" id="nom" name="nom" required><br>

    <label for="directeur">Directeur :</label>
    <input type="text" id="directeur" name="directeur" required><br>

    <label for="adresse">Adresse :</label>
    <input type="text" id="adresse" name="adresse" required><br>

    <label for="telephone">Téléphone :</label>
    <input type="text" id="telephone" name="telephone" required><br>

    <label for="email">Email :</label>
    <input type="email" id="email" name="email" required><br>

    <label for="type">Type :</label>
    <select id="type" name="type" required>
        <option value="privé">Privé</option>
        <option value="public">Public</option>
    </select><br>

    <button type="submit">Créer Établissement</button>
</form>
