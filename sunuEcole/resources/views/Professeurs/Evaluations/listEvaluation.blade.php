<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Évaluations pour la Classe</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/canvas.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<div class="container my-4">
    <div class="mt-3 mb-4">
        <img src="{{ asset('assets/img/canvas.png') }}" alt="Logo">
    </div>
    <div class="row">
        <div class="col-md-12">
            <td><a href="{{ route('professeurs.prof.dashboard') }}">Retour à votre espace personnel</a></td>
            <h1 class="mb-4">Évaluations pour la Classe {{ $classe->nom }}</h1>
            @if ($evaluations->isEmpty())
                <p>Aucune Evaluations Programmer pour le moment.</p>
            @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>Titre</th>
                            <th>Type</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($evaluations as $evaluation)
                            <tr>
                                <td>{{ $evaluation->titre }}</td>
                                <td>{{ $evaluation->type }}</td>
                                <td>{{ $evaluation->jours }}</td>
                                <td><a href="{{ route('professeurs.evaluations.add_notes', ['classeId' => $classe->id, 'evaluationId' => $evaluation->id]) }}" class="btn btn-primary">Ajouter des Notes</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
            <a href="{{ route('professeurs.evaluations.create', $classe->id) }}" class="btn btn-primary">Programmer une évaluation</a>
        </div>
    </div>
</div>
</body>
</html>
