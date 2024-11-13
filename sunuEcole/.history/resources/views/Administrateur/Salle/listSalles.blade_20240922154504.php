<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salles Disponibles pour la Classe {{ $classe->nom }}</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/canvas.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
@include('layouts.nav')
<body>
<div class="container mt-5">
    <h1 class="text-secondary">Salles Disponibles pour la Classe {{ $classe->nom }}</h1>

    @if ($salles->isEmpty())
        <p>Aucune salle disponible pour le moment.</p>
    @else
        <table class="table mt-3">
            <thead>
                <tr class="table-primary">
                    <th>Numéro</th>
                    <th>Capacité</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($salles as $salle)
                    <tr>
                        <td>{{ $salle->numéro }}</td>
                        <td>{{ $salle->capaciter }}</td>
                        <td>
                            <form action="{{ route('professeurs.cours.assignSalle', ['coursId' => $cours->id, 'salleId' => $salle->id]) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm">Choisir cette salle</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <a href="{{ route('professeurs.cours.detail.prof', $cours->id) }}" class="btn btn-secondary mt-3">Retourner au détail du cours</a>
</div>
</body>
</html>
