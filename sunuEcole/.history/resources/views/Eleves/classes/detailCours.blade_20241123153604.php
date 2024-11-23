<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Cours</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/canvas.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    @include('partials.navElv')

    <div class="container my-4 text-secondary">
        <div class="row">
            <div class="col-md-6">
                <h1 class="mb-4">Détails du Cours</h1>
                <p><strong>Titre :</strong> {{ $cours->titre }}</p>
                <p><strong>Description :</strong> {{ $cours->descriptions }}</p>
                <p><strong>Jour :</strong> {{ $cours->jours }}</p>
                <p><strong>Heure de début :</strong> {{ $cours->heure_debut }}</p>
                <p><strong>Heure de fin :</strong> {{ $cours->heure_fin }}</p>
                <p><strong>Professeur :</strong> {{ $cours->professeur->prenoms }} {{ $cours->professeur->nom }}</p>
                <p><strong>Salle de classe :</strong> 
                    @if ($cours->salleDeClasse)
                        {{ $cours->salleDeClasse->numéro }}
                    @else
                        Aucune salle de classe attribuée
                    @endif
                </p>
                <p><strong>Fichier du cours :</strong> <a href="{{ route('eleves.download',{{ dd($cours->id) }}
) }}" target="_blank">Télécharger le cours</a>
                </p>
                
            </div>

            <div class="col-md-6">
                <img src="{{ asset('assets/img/courlist.jpg') }}" alt="Image description" class="img-fluid">
            </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-4dUosZBzLv6/jYbbXsYrgg4QyVj2/j4vKMC/kpBlh24o3w2L1gmbv2JWo1IoewNn" crossorigin="anonymous"></script>
    <div class="container text-center mt-4">
        <button onclick="window.history.back()" class="btn btn-primary">Retour</button>
    </div>
</body>
</html>
