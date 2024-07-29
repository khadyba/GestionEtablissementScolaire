<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Classes</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/canvas.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    @include('partials.navElv')

    <div class="container my-4 text-secondary">
        <div class="row">
            <div class="col-md-6">
                <h1 class="mb-4">Liste des Classes</h1>
                @if ($classes->isNotEmpty())
                    <ul class="list-group">
                        @foreach ($classes as $classe)
                            <li class="list-group-item">
                                <a href="{{ route('eleves.classes.detail', ['id' => $classe->id]) }}">
                                    {{ $classe->nom }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p>Aucune classe disponible pour le moment.</p>
                @endif
            </div>
            <div class="col-md-6 d-flex justify-content-center align-items-center">
                <img src="{{ asset('assets/img/classeelv.jpg') }}" alt="Image description" class="img-fluid">
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-4dUosZBzLv6/jYbbXsYrgg4QyVj2/j4vKMC/kpBlh24o3w2L1gmbv2JWo1IoewNn" crossorigin="anonymous"></script>
</body>
</html>
