<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Cours</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/canvas.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
@include('partials.navProf')
<body>
<div class="container my-4">
    <div class="row">
        <div class="col-md-8">
            @if ($cours)
                <h1 class="mb-4 text-secondary">Détails du Cours</h1>
                <div class="mb-4 text-secondary">
                    <p><strong>Titre :</strong> {{ $cours->titre }}</p>
                    <p><strong>Description :</strong> {{ $cours->descriptions }}</p>
                    <p><strong>Jour :</strong> {{ $cours->jours }}</p>
                    <p><strong>Heure de début :</strong> {{ $cours->heure_debut }}</p>
                    <p><strong>Heure de fin :</strong> {{ $cours->heure_fin }}</p>
                    <p><strong>Professeur :</strong> {{ $cours->professeur->nom }} {{ $cours->professeur->prenoms }}</p>
                    <p><strong>Salle de classe :</strong> 
                    @if ($cours->salleDeClasse)
                        {{ $cours->salleDeClasse->numéro }}
                    @else
                        Aucune salle de classe attribuée
                    @endifcourlis
                    </p>
                    <p><strong>Fichier du cours :</strong> <a href="{{ Storage::url($cours->fichier_cours) }}" target="_blank">Télécharger le cours</a></p>
                </div>
            @else
                <p>Le cours demandé n'existe pas ou a été supprimé.</p>
            @endif
            <a href="{{ route('professeurs.cours.list', $classe) }}" class="btn btn-primary">Retour à la liste des cours</a>
        </div>
        <div class="col-md-4">
           
            <img src="{{ asset('assets/img/cour-detail.png') }}" alt="Détails du Cours" class="img-fluid">
        </div>
    </div>

    <h2 class="mt-4">Actions supplémentaires</h2>
    <ul>
        <li><a href="{{ route('professeurs.salle.disponible', ['id' => $classe]) }}" class="btn btn-info">Voir les salles disponibles pour cette classe</a></li>
    </ul>
</div>
</body>
</html>
