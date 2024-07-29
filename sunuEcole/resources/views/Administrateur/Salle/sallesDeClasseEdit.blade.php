<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier la Salle de Classe</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/canvas.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
@include('layouts.nav')
<body>
<div class="container mt-5">
    <h1 class="text-secondary">Modifier la Salle de Classe</h1>
    <div class="row">
        <div class="col-md-6">
            <form action="{{ route('admin.salles-de-classe.update', $salle->id) }}" method="POST">
                @csrf
                @method('POST')

                <div class="mb-3">
                    <label for="numéro" class="form-label">Numéro :</label>
                    <input type="text" name="numéro" id="numéro" class="form-control" value="{{ $salle->numéro }}" required>
                </div>

                <div class="mb-3">
                    <label for="capaciter" class="form-label">Capacité :</label>
                    <input type="text" name="capaciter" id="capaciter" class="form-control" value="{{ $salle->capaciter }}" required>
                </div>

                <div class="mb-3">
                    <label for="statut" class="form-label">Statut :</label>
                    <select name="statut" id="statut" class="form-select" required>
                        <option value="libre" {{ $salle->statut == 'libre' ? 'selected' : '' }}>Libre</option>
                        <option value="occupée" {{ $salle->statut == 'occupée' ? 'selected' : '' }}>Occupée</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Mettre à jour</button>
            </form>
        </div>
        <div class="col-md-6">
        <img src="{{ asset('assets/img/classe.jpg') }}" alt="Image description" class="img-fluid ">
        </div>
    </div>
</div>
</body>
</html>
