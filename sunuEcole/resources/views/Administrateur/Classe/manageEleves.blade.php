<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer les Élèves</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/canvas.png') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
@include('layouts.nav')

<body>
<div class="container my-4">
        <div class="mt-3 mb-4">
        <img src="{{ asset('assets/img/canvas.png') }}" alt="Sunulyce Logo">
        </div>
    <h1 class="text-secondary">Gérer les Élèves pour la Classe {{ $classe->nom }}</h1>
    <a href="{{ route('classes.show', $classe->id) }}" class="btn btn-primary mb-3">Retourner à la Classe</a>
    <div class="row">
        <div class="col-md-6">
            <table class="table">
                <thead>
                    <tr class="table-primary">
                        <th>Nom</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($eleves) && $eleves->count())
                        @foreach($eleves as $eleve)
                            <tr>
                                <td class="table-secondary">{{ $eleve->prenoms }} {{ $eleve->nom }}</td>
                                <td class="table-danger">
                                    <form action="{{ route('classes.eleve.detach', ['classeId' => $classe->id, 'eleveId' =>  $eleve->id]) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir retirer cet élève de la classe ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Retirer</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="2" class="text-center">Aucun élève trouvé</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <div class="col-md-6 d-flex justify-content-center align-items-center">
            <img src="{{ asset('assets/img/classe.jpg') }}" alt="Image description" class="img-fluid w-75">
        </div>
    </div>
</div>
</body>
</html>
