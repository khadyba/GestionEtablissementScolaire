<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notes pour la Classe {{ $classe->nom }}</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/canvas.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
@include('layouts.nav')

<body>
<div class="container my-4">
    @if(session('success'))
        <div class="alert alert-success mb-4">
            {{ session('success') }}
        </div>
    @endif

    <h1 class="mb-4 text-secondary">Notes pour la Classe {{ $classe->nom }}</h1>

    @foreach ($classe->eleve as $eleve)
        <h3 class="text-secondary">{{ $eleve->prenoms }} {{ $eleve->nom }}</h3>
        <table class="table table-striped">
            <thead>
                <tr class="table-primary">
                    <th>Évaluation</th>
                    <th>Note</th>
                    <th>Coefficient</th>
                    <th>Appréciations</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($eleve->notes as $note)
                    <tr>
                        <td>{{ $note->evaluation->type }} {{ $note->evaluation->titre }}</td>
                        <td>{{ $note->valeur }}</td>
                        <td>{{ $note->coefficient }}</td>
                        <td>{{ $note->appreciations }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mb-3">
            <a href="{{ route('eleves.calculer_moyenne', [$eleve->id]) }}" class="btn btn-primary me-2">Calculer la Moyenne</a>
            <a href="{{ route('eleves.bulletin', [$classe->id, $eleve->id]) }}" class="btn btn-secondary me-2">Générer le Bulletin</a>
            <a href="{{ route('classes.bulletin', [$classe->id, $eleve->id]) }}" class="btn btn-secondary">Voir le Bulletin</a>
        </div>
    @endforeach
    <button onclick="window.history.back()" class="btn btn-light">Retour</button>
</div>
</body>
</html>
