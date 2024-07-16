


<div class="container">
    <h1>Modifier le Cours</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('professeurs.cours.update', $cours->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="titre">Titre :</label>
            <input type="text" name="titre" id="titre" class="form-control" value="{{ $cours->titre }}" required>
        </div>

        <div class="form-group">
            <label for="descriptions">Description :</label>
            <textarea name="descriptions" id="descriptions" class="form-control" required>{{ $cours->descriptions }}</textarea>
        </div>

        <div class="form-group">
            <label for="jours">Jour :</label>
            <input type="date" name="jours" id="jours" class="form-control" value="{{ $cours->jours }}" required>
        </div>

        <div class="form-group">
            <label for="heure_debut">Heure de début :</label>
            <input type="time" name="heure_debut" id="heure_debut" class="form-control" value="{{ old('heure_debut', $cours->heure_debut) }}" required>
        </div>

        <div class="form-group">
            <label for="heure_fin">Heure de fin :</label>
            <input type="time" name="heure_fin" id="heure_fin" class="form-control" value="{{ old('heure_fin', $cours->heure_fin) }}" required>
        </div>


        <div class="form-group">
            <label for="fichier_cours">Fichier du cours :</label>
            <input type="file" name="fichier_cours" id="fichier_cours" class="form-control">
            @if ($cours->fichier_cours)
                <p>Fichier actuel : <a href="{{ Storage::url($cours->fichier_cours) }}" target="_blank">Télécharger le cours</a></p>
            @endif
        </div>

        <div class="form-group">
            <label for="salle_de_classe_id">Salle de classe :</label>
            <select name="salle_de_classe_id" id="salle_de_classe_id" class="form-control">
                @foreach($sallesDeClasses as $salle)
                    <option value="{{ $salle->id }}">{{ $salle->numero }} - Capacité: {{ $salle->capaciter }} - Statut: {{ $salle->statut }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
        <a href="{{ route('professeurs.cours.list.prof') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>

