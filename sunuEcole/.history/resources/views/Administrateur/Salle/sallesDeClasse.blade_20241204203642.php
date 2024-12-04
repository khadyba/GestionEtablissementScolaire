<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Salles de Classe</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/canvas.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
@include('layouts.nav')
<body>
<div class="container mt-5">
    <h1 class="text-secondary">Liste des Salles de Classe</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered mt-3">
        <thead>
            <tr class="table-primary">
                <th>Numéro</th>
                <th>Capacité</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
    @if($sallesDeClasse->isEmpty())
        <tr>
            <td colspan="4" class="text-center">Aucune salle de classe trouvée</td>
        </tr>
    @else
        @foreach ($sallesDeClasse as $salle)
            <tr>
                <td>{{ $salle->numéro }}</td>
                <td>{{ $salle->capaciter }}</td>
                <td>{{ $salle->statut }}</td>
                <td>
                    <a href="{{ route('admin.salles-de-classe.edit', $salle->id) }}" class="btn btn-primary btn-sm me-2">Modifier</a>
                    <form action="{{ route('admin.salles-de-classe.destroy', $salle->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette salle de classe ?')">Supprimer</button>
                    </form>
                </td>
            </tr>
        @endforeach
    @endif
</tbody>

</div>
</body>
</html>
