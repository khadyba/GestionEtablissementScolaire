<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter des Notes</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/canvas.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
@include('partials.navProf')
<body>
<div class="container my-4">
    <div class="row">
        <div class="col-md-6">
            <h1 class="mb-4 text-secondary">Ajouter des Notes pour l'Évaluation {{ $evaluation->titre }} dans la Classe {{ $classe->nom }}</h1>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('professeurs.evaluations.store_notes',  $classe->id) }}" method="POST">
                @csrf

                @foreach ($eleves as $eleve)
                    <h3>{{ $eleve->prenoms }} {{ $eleve->nom }}</h3>

                    <div class="mb-3">
                        <label for="notes[{{ $eleve->id }}][valeur]" class="form-label">Note pour {{ $evaluation->titre }} ({{ $evaluation->type }}):</label>
                        <input type="number" name="notes[{{ $eleve->id }}][valeur]" class="form-control" id="notes[{{ $eleve->id }}][valeur]" required>

                        <label for="notes[{{ $eleve->id }}][coefficient]" class="form-label">Coefficient:</label>
                        <input type="number" name="notes[{{ $eleve->id }}][coefficient]" class="form-control" id="notes[{{ $eleve->id }}][coefficient]" required>

                        <!-- Hidden inputs pour evaluation_id et eleve_id -->
                        <input type="hidden" name="notes[{{ $eleve->id }}][evaluation_id]" value="{{ $evaluation->id }}">
                        <input type="hidden" name="notes[{{ $eleve->id }}][eleve_id]" value="{{ $eleve->id }}">

                        <div class="mb-3">
                            <label for="notes[{{ $eleve->id }}][appreciations]" class="form-label">Appréciations:</label>
                            <textarea name="notes[{{ $eleve->id }}][appreciations]" class="form-control" id="notes[{{ $eleve->id }}][appreciations]"></textarea>
                        </div>
                    </div>
                @endforeach

                <button type="submit" class="btn btn-primary">Enregistrer les notes</button>
            </form>
        </div>
        <div class="col-md-6">
            <img src="{{ asset('assets/img/0-20.png') }}" alt="Notes" class="img-fluid">
        </div>
    </div>
</div>
</body>
</html>
