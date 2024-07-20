<!DOCTYPE html>
<html>
<head>
    <title>Modifier la Note</title>
</head>
<body>
    <div class="container">
        <h1>Modifier la Note pour {{ $note->eleve->prenoms }} {{ $note->eleve->nom }}</h1>

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

            <div class="form-group">
                <label for="valeur">Note:</label>
                <input type="number" name="valeur" class="form-control" id="valeur" value="{{ old('valeur', $note->valeur) }}" required>
            </div>

            <div class="form-group">
                <label for="appreciations">Appréciations:</label>
                <textarea name="appreciations" class="form-control" id="appreciations">{{ old('appreciations', $note->appreciations) }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
        </form>
    </div>
</body>
</html>
