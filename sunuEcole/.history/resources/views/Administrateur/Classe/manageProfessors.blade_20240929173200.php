<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer les Professeurs</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/canvas.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
@include('layouts.nav')

<body>
<div class="container my-4">
        <div class="mt-3 mb-4">
        <img src="{{ asset('assets/img/canvas.png') }}" alt="Sunulyce Logo">
        </div>
    <h1 class="text-secondary">Gérer les Professeurs pour la Classe {{ $classe->nom }}</h1>
    <a href="{{ route('classes.show', $classe->id) }}" class="btn btn-primary mb-3">Retourner à la Classe</a>

    <div class="row">
        <div class="col-md-6">
            <table class="table">
                <thead>
                    <tr class="table-primary">
                        <th>Nom</th>
                        <th></th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($professeurs as $professeur)
                        <tr>
                            <td class="table-secondary">{{ $professeur->prenoms }} {{ $professeur->nom }}</td>
                            <td class="table-info">{{ $professeur->spécialiter }}</td>
                            <td class="table-danger">
                                <form action="{{ route('classes.professeurs.detach', ['classeId' => $classe->id, 'professeurId' => $professeur->id]) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir retirer ce professeur de la classe ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Retirer</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-md-6 d-flex justify-content-center align-items-center">
            <img src="{{ asset('assets/img/classe.jpg') }}" alt="Image description" class="img-fluid w-75">
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-8q3M7+Nyk3h71+Jld7oVk3Bq5LM5UBM2Zof2bl6cf1hUVOy6tGJ+6uoyfxg4S2yE" crossorigin="anonymous"></script>
</body>
</html>
