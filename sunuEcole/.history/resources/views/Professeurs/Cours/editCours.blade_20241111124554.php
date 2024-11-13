<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le Cours</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/canvas.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
@include('partials.navProf')
<body>
<div class="container my-4">
    <a href="{{ route('professeurs.dashboard') }}" class="btn btn-secondary mb-4">Retour à votre espace personnel</a>
    
    <div class="row">
        <div class="col-md-8">
            <h1 class="mb-4">Modifier le Cours</h1>
            @if ($errors->any())
                <div class="alert alert-danger mb-4">
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

                <div class="form-group mb-3">
                    <label for="titre">Titre :</label>
                    <input type="text" name="titre" id="titre" class="form-control" value="{{ $cours->titre }}" required>
                </div>

                <div class="form-group mb-3">
                    <label for="descriptions">Description :</label>
                    <textarea name="descriptions" id="descriptions" class="form-control" required>{{ $cours->descriptions }}</textarea>
                </div>

                <div class="form-group mb-3">
                    <label for="jours">Jour :</label>
                    <input type="date" name="jours" id="jours" class="form-control" value="{{ $cours->jours }}" required>
                </div>

                <div class="form-group mb-3">
                    <label for="heure_debut">Heure de début :</label>
                    <input type="time" name="heure_debut" id="heure_debut" class="form-control" value="{{ old('heure_debut', $cours->heure_debut) }}" required>
                </div>

                <div class="form-group mb-3">
                    <label for="heure_fin">Heure de fin :</label>
                    <input type="time" name="heure_fin" id="heure_fin" class="form-control" value="{{ old('heure_fin', $cours->heure_fin) }}" required>
                </div>

                <div class="form-group mb-3">
                    <label for="fichier_cours">Fichier du cours :</label>
                    <input type="file" name="fichier_cours" id="fichier_cours" class="form-control">
                    @if ($cours->fichier_cours)
                        <p class="mt-2">Fichier actuel : <a href="{{ Storage::url($cours->fichier_cours) }}" target="_blank">Télécharger le cours</a></p>
                    @endif
                </div>

                <div class="form-group mb-3">
                    <label for="salle_de_classe_id">Salle de classe :</label>
                    <select name="salle_de_classe_id" id="salle_de_classe_id" class="form-control">
                        @foreach($sallesDeClasses as $salle)
                            <option value="{{ $salle->id }}" {{ $cours->salle_de_classe_id == $salle->id ? 'selected' : '' }}>
                                {{ $salle->numero }} - Capacité: {{ $salle->capaciter }} - Statut: {{ $salle->statut }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                <a href="{{ route('professeurs.cours.list', ['id' => $cours->id]) }}" class="btn btn-secondary">Annuler</a>

            </form>
        </div>

        <div class="col-md-4">
            <img src="{{ asset('assets/img/cour-edit.png') }}" alt="Modifier le Cours" class="img-fluid">
        </div>
    </div>
</div>
</body>
</html>
