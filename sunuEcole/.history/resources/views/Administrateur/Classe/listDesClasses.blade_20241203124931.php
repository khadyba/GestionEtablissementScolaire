<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Liste Des Classes</title>
<link rel="icon" type="image/png" href="{{ asset('assets/img/canvas.png') }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
@include('layouts.nav')
<body>
<div class="container">
            @if(session('success'))
                <div class="alert alert-success">
                    {!! session('success') !!}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {!! session('error') !!}
                </div>
            @endif
            <tbody>
    @forelse($classes as $classe)
        <tr class="{{ $loop->index % 2 == 0 ? 'table-light' : 'table-dark' }}">
            <td>{{ $classe->nom }}</td>
            <td>{{ $classe->niveau }}</td>
            <td>{{ $classe->administrateur->nom ?? 'Inconnu' }}</td>
            <td>
                <div class="d-flex justify-content-between">
                    <a href="{{ route('classes.edit', $classe->id) }}" class="btn btn-primary btn-sm me-2">Modifier</a>
                    <form action="{{ route('classes.destroy', $classe->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm me-2">Supprimer</button>
                    </form>
                    <a href="{{ route('classes.show', $classe->id) }}" class="btn btn-primary btn-sm me-2">Voir Détails</a>
                </div>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="4">Aucune classe trouvée.</td>
        </tr>
    @endforelse
</tbody>

</body>
</html>
