<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Élèves</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/canvas.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
@include('partials.navElv')
<body>
<div class="container">
        @if (session()->has('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif


        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif
    <div class="container mt-5 text-secondary">
        <div class="row">
            <!-- Colonne pour la liste des classes -->
            <div class="col-md-8">
                <h1 class="mb-4">Liste des Classes</h1>
                <ul class="list-unstyled">
                    @foreach ($classes as $classe)
                        <li class="mb-2">
                            <a href="{{ route('eleves.classes.detail', ['id' => $classe->id]) }}" class="h5 text-decoration-none text-primary">
                                {{ $classe->nom }}
                            </a>
                            <a href="{{ route('eleves.evaluations.list', ['classe' => $classe->id]) }}" class="btn btn-info btn-sm ms-2">Voir les Évaluations</a>
                        </li>
                    @endforeach
                </ul>

                <!-- Boutons d'Action -->
                <div class="mt-4">
                    <a href="{{ route('eleves.payInscription') }}" class="btn btn-primary" target="_blank">Payer mon inscription</a>
                    <a href="{{ route('eleves.notes.list') }}" class="btn btn-primary ms-2">Consulter mes Notes</a>
                </div>
            </div>

            <!-- Colonne pour l'image -->
            <div class="col-md-4">
                <img src="{{ asset('assets/img/eleves.jpg') }}" alt="Image Description" class="img-fluid">
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-4dUosZBzLv6/jYbbXsYrgg4QyVj2/j4vKMC/kpBlh24o3w2L1gmbv2JWo1IoewNn" crossorigin="anonymous"></script>
</body>
</html>
