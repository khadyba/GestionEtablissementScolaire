
<div class="container">
    <td><a href="{{ route('professeurs.prof.dashboard') }}">Retour à votre espace personnel</a></td>

    <h1>Programmer une Évaluation pour la classe {{ $classe->nom }}</h1>

    <form action="{{ route('professeurs.evaluations.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="titre">Titre</label>
            <input type="text" name="titre" id="titre" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="type">Type</label>
            <input type="text" name="type" id="type" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="jours">Jour</label>
            <input type="date" name="jours" id="jours" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="heure_debut">Heure de début</label>
            <input type="time" name="heure_debut" id="heure_debut" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="heure_fin">Heure de fin</label>
            <input type="time" name="heure_fin" id="heure_fin" class="form-control" required>
        </div>
        <input type="hidden" name="classe_id" value="{{ $classe->id }}">
        <button type="submit" class="btn btn-primary">Programmer Évaluation</button>
    </form>
</div>




















<!-- <div class="container">
    <h1>Programmer une évaluation pour la classe {{ $classe->nom }}</h1>

    <form action="{{ route('professeurs.evaluations.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="titre">Titre :</label>
            <input type="text" name="titre" id="titre" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="type">Type :</label>
            <input type="text" name="type" id="type" class="form-control" required>
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
        <input type="hidden" name="classe_id" value="{{ $classe->id }}">
        <button type="submit" class="btn btn-primary">Programmer</button>
    </form>
</div> -->
