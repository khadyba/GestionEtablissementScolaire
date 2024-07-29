<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Liste des Cours</title>
<link rel="icon" type="image/png" href="{{ asset('assets/img/canvas.png') }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
@include('layouts.nav')
<body>
<div class="container">
    <div class="row mt-5">
        <div class="mb-3">
            <h1 class="text-secondary">Liste des Cours de la classe {{ $classe->nom }}</h1>
        </div>
        @if ($cours->isEmpty())
            <p>Aucun cours ajouté pour cette classe.</p>
        @else
            <table class="table">
                <thead>
                    <tr class="table-primary">
                        <th>Titre</th>
                        <th>Description</th>
                        <th>Professeur</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cours as $coursItem)
                        <tr class="{{ $loop->index % 2 == 0 ? 'table-light' : 'table-dark' }}">
                            <td>{{ $coursItem->titre }}</td>
                            <td>{{ $coursItem->description }}</td>
                            <td>
                                @if ($coursItem->professeur)
                                    {{ $coursItem->professeur->prenoms }} {{ $coursItem->professeur->nom }}
                                @else
                                    Aucun professeur assigné
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
</body>
</html>
