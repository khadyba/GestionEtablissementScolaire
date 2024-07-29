<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier la Note</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/canvas.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
@include('partials.navProf')
<body>
<div class="container my-4">
    <h1 class="mb-4 text-secondary">Modifier la Note pour {{ $note->eleve->prenoms }} {{ $note->eleve->nom }}</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('professeurs.notes.update', $note->id) }}" method="POST">
        @csrf
        @method('POST') 

        <div class="mb-3">
            <label for="valeur" class="form-label">Note:</label>
            <input type="number" name="valeur" class="form-control" id="valeur" value="{{ old('valeur', $note->valeur) }}" required>
        </div>

        <div class="mb-3">
            <label for="appreciations" class="form-label">Appréciations:</label>
            <textarea name="appreciations" class="form-control" id="appreciations">{{ old('appreciations', $note->appreciations) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
    </form>
</div>
</body>
</html>
