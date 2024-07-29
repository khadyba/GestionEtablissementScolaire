<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de la Classe</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/canvas.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
@include('partials.navElv')
<body>
    <div class="container my-4">
        <div class="row">
            <div class="col-md-6">
                <h1 class="mb-4">Classe: {{ $classe->nom }}</h1>
                <p><strong>Niveau:</strong> {{ $classe->niveau }}</p>
                <h2 class="mt-4">Élèves assignés</h2>
                <ul class="list-group">
                    @if ($classe->eleve->isNotEmpty())
                        @foreach($classe->eleve as $eleves)
                            <li class="list-group-item">{{ $eleves->prenoms }} {{ $eleves->nom }}</li>
                        @endforeach
                    @else
                        <li class="list-group-item">Aucun élève assigné</li>
                    @endif
                </ul>

                <h2 class="mt-4">Professeurs assignés</h2>
                <ul class="list-group">
                    @if ($classe->professeurs->isNotEmpty())
                        @foreach($classe->professeurs as $professeur)
                            <li class="list-group-item">{{ $professeur->prenoms }} {{ $professeur->nom }} - {{ $professeur->spécialiter }}</li>
                        @endforeach
                    @else
                        <li class="list-group-item">Aucun professeur assigné</li>
                    @endif
                </ul>

                <h2 class="mt-4">Emploi du temps</h2>
                @if ($classe->emploisDuTemps->isNotEmpty())
                    <ul class="list-group">
                        @foreach ($classe->emploisDuTemps as $emploiDuTemps)
                            <li class="list-group-item">
                                <a href="{{ Storage::url($emploiDuTemps->emplois_du_temps) }}" target="_blank">{{ $emploiDuTemps->nom_original }}</a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p>Aucun emploi du temps disponible pour cette classe.</p>
                @endif

                <div class="mt-4">
                    <a href="{{ route('eleves.cours.index', ['id' => $classe->id]) }}" class="btn btn-primary">Voir la liste des Cours</a>
                    <a href="{{ route('eleves.classes.index') }}" class="btn btn-primary">Retour à la liste des classes</a>
                </div>
            </div>

            <div class="col-md-6 d-flex justify-content-center align-items-center">
                <img src="{{ asset('assets/img/ouverture.jpg') }}" alt="Image description" class="img-fluid">
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-4dUosZBzLv6/jYbbXsYrgg4QyVj2/j4vKMC/kpBlh24o3w2L1gmbv2JWo1IoewNn" crossorigin="anonymous"></script>
</body>
</html>
