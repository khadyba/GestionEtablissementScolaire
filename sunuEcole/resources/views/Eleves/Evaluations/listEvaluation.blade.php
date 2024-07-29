<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Évaluations pour la Classe</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/canvas.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    @include('partials.navElv')

    <div class="container my-4">
        <h1 class="mb-4 text-secondary">Évaluations programmées pour la Classe {{ $classe->nom }}</h1>
        
        @if ($evaluations->isEmpty())
            <p>Aucune évaluation programmée pour le moment.</p>
        @else
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Type</th>
                        <th>Date</th>
                        <th>Heure de début</th>
                        <th>Heure de fin</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($evaluations as $evaluation)
                        <tr>
                            <td>{{ $evaluation->titre }}</td>
                            <td>{{ $evaluation->type }}</td>
                            <td>{{ $evaluation->jours }}</td>
                            <td>{{ $evaluation->heure_debut }}</td>
                            <td>{{ $evaluation->heure_fin }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-4dUosZBzLv6/jYbbXsYrgg4QyVj2/j4vKMC/kpBlh24o3w2L1gmbv2JWo1IoewNn" crossorigin="anonymous"></script>
    <div class="container text-center mt-4">
        <button onclick="window.history.back()" class="btn btn-primary">Retour</button>
    </div>
</body>
</html>
