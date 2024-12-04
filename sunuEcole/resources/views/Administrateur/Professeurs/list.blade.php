<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/canvas.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
@include('layouts.nav')
<body>

<div class="container">
    <h1>Liste des professeurs</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
    @forelse($professeurs as $professeur)
        <tr>
            <td>{{ $professeur->id }}</td>
            <td>{{ $professeur->nom }}</td>
            <td>{{ $professeur->email }}</td>
            <td>
                <form action="{{ route('professeurs.destroy', $professeur->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Désactiver le compte</button>
                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="4">Aucun professeur trouvé dans votre établissement.</td>
        </tr>
    @endforelse
</tbody>

    </table>
</div>
</body>
</html>
