<div class="container">
    <h1>Créer un nouveau cours</h1>

    <form action="{{ route('cours.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="titre">Titre :</label>
            <input type="text" name="titre" id="titre" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="descriptions">Description :</label>
            <textarea name="descriptions" id="descriptions" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label for="jours">Jour :</label>
            <input type="date" name="jours" id="jours" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="heure_debut">Heure de début :</label>
            <input type="time" name="heure_debut" id="heure_debut" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="heure_fin">Heure de fin :</label>
            <input type="time" name="heure_fin" id="heure_fin" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="fichier_cours">Fichier du cours :</label>
            <input type="text" name="fichier_cours" id="fichier_cours" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="classe">Sélectionner une classe :</label>
            <select name="classe_id" id="classe" class="form-control">
                @foreach($classes as $classe)
                    <option value="{{ $classe->id }}">{{ $classe->nom }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Créer</button>
    </form>
</div>
