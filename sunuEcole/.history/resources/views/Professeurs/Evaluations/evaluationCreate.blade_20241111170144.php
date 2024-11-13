<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Programmer une Évaluation</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/canvas.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
@include('partials.navProf')
<body>
<div class="container my-4">
        @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <pre>{{ print_r(session()->all(), true) }}</pre>

    <div class="row">
        <div class="col-md-6">
            <h1 class="mb-4 text-secondary">Programmer une Évaluation pour la classe {{ $classe->nom }} {{ $classe->niveau }}</h1>
           
            <form action="{{ route('professeurs.evaluations.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="titre" class="form-label">Titre :</label>
                    <input type="text" name="titre" id="titre" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="type" class="form-label">Type :</label>
                    <input type="text" name="type" id="type" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="jours" class="form-label">Jour :</label>
                    <input type="date" name="jours" id="jours" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="heure_debut" class="form-label">Heure de début :</label>
                    <input type="time" name="heure_debut" id="heure_debut" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="heure_fin" class="form-label">Heure de fin :</label>
                    <input type="time" name="heure_fin" id="heure_fin" class="form-control" required>
                </div>

                <input type="hidden" name="classe_id" value="{{ $classe->id }}">

                <button type="submit" class="btn btn-primary">Programmer l'Évaluation</button>
            </form>
        </div>
        <div class="col-md-6  d-flex justify-content-center align-items-center">
            <img src="{{ asset('assets/img/evaluations.jpg') }}" alt="Évaluation" class="img-fluid">
        </div>
    </div>
</div>
</body>
</html>
