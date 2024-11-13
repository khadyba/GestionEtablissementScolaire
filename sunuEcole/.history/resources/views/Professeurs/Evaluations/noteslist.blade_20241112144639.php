<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Notes</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/canvas.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
@include('partials.navProf')
<body>
<div class="container my-4">
    <div class="row">
        <div class="col-md-12">
            <h1 class="mb-4 text-secondary">Liste des Notes</h1>
            
            @if ($notes->isEmpty())
                <p class="text-secondary">Aucune Note enregistré  pour le moment.</p>
            @else
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Élève</th>
                            <th>Évaluation</th>
                            <th>Note</th>
                            <th>Appréciations</th>
                            <th>Coefficient</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($notes as $note)
                            <tr>
                                <td>{{ $note->eleve->prenoms }} {{ $note->eleve->nom }}</td>
                                <td>{{ $note->evaluation->type }} {{ $note->evaluation->titre }} </td>
                                <td>{{ $note->valeur }}</td>
                                <td>{{ $note->appreciations }}</td>
                                <td>{{ $note->coefficient }}</td>
                                <td>
                                    <a href="{{ route('professeurs.notes.edit', $note->id) }}" class="btn btn-primary btn-sm">Modifier</a>
                                    <form action="{{ route('professeurs.notes.delete', $note->id) }}" method="POST" style="display:inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette note ?')">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>



</body>
</html>
