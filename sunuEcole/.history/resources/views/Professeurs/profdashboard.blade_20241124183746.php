<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professeurs Dashboard</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/canvas.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Link to external CSS file -->
    <!-- <link rel="stylesheet" href="{{ asset('assets/css/admin-dashboard.css') }}"> -->
</head>
@include('partials.navProf')
<body>
@if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
    <div class="container mt-5">
        <h1 class="mt-4 text-secondary">Liste des classes</h1>
        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th scope="col">Nom</th>
                    <th scope="col">Niveau</th>
                    <th scope="col">Établissement</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($classes as $classe)
                    <tr>
                        <td>{{ $classe->nom }}</td>
                        <td>{{ $classe->niveau }}</td>
                        <td>{{ $classe->etablissement->nom }}</td>
                        <td>
                            <a href="{{ route('professeurs.cours.create', $classe->id) }}" class="btn btn-primary btn-sm">Ajouter Cours</a>
                            
                            <a href="{{ route('professeurs.classes.show', $classe->id) }}" class="btn btn-info btn-sm">Voir Detail</a>
                            <a href="{{ route('professeurs.evaluations.list', $classe->id) }}" class="btn btn-warning btn-sm">Voir Évaluations</a>
                            <a href="{{ route('professeurs.notes.list',  ['classeId' => $classe->id]) }}" class="btn btn-success btn-sm">Liste des Notes</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-4dUosZBzLv6/jYbbXsYrgg4QyVj2/j4vKMC/kpBlh24o3w2L1gmbv2JWo1IoewNn" crossorigin="anonymous"></script>
</body>
</html>
