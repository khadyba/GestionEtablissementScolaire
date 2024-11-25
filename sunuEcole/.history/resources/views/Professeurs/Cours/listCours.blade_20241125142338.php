<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Cours</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/canvas.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
    crossorigin="anonymous">
</head>
@include('partials.navProf')
<body>
<div class="container my-4">
    <div class="row">
        <div class="col-md-8">
            <h1 class="mb-4">Liste des Cours de la classe {{ $classe->nom }} {{ $classe->niveau }}</h1>

            @if ($cours->isEmpty())
                <p>Aucun cours ajouté pour cette classe.</p>
            @else
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Titre</th>
                            <th>Description</th>
                            <th>Professeur</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cours as $coursItem)
                            <tr>
                                <td>{{ $coursItem->titre }}</td>
                                <td>{{ $coursItem->descriptions }}</td>
                                <td>
                                    @if ($coursItem->professeur)
                                        {{ $coursItem->professeur->prenoms }} {{ $coursItem->professeur->nom }}
                                    @else
                                        Aucun professeur assigné
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('professeurs.cours.detail', $coursItem->id) }}" class="btn btn-info btn-sm">Voir détails</a>
                                    @if ($coursItem->professeur_id == auth()->user()->professeur->id)
                                        <a href="{{ route('professeurs.cours.edit', $coursItem->id) }}" class="btn btn-warning btn-sm">Modifier</a>
                                        <form action="{{ route('professeurs.cours.destroy', $coursItem->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce cours ?')">Supprimer</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        <div class="col-md-4">
            <img src="{{ asset('assets/img/courlist.') }}" alt="Liste des Cours" class="img-fluid">
        </div>
    </div>
</div>
</body>
</html>
