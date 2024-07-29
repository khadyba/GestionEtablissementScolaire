<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Cours</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/canvas.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
@include('partials.navElv')
<body>
    <div class="container my-4 text-secondary">
        <div class="row">
            <div class="col-md-6">
                <h1 class="mb-4">Liste des Cours pour la Classe {{ $classe->nom }}</h1>
                
                @if ($cours->isNotEmpty())
                    <ul class="list-group">
                        @foreach ($cours as $cour)
                            <li class="list-group-item">
                                <a href="{{ route('eleves.cours.detail', ['id' => $cour->id]) }}" class="text-decoration-none">
                                    {{ $cour->titre }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p>Aucun cours disponible pour cette classe.</p>
                @endif

            

            </div>
            <div class="col-md-6">
                <img src="{{ asset('assets/img/courlist.jpg') }}" alt="Image description" class="img-fluid">
            </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-4dUosZBzLv6/jYbbXsYrgg4QyVj2/j4vKMC/kpBlh24o3w2L1gmbv2JWo1IoewNn" crossorigin="anonymous"></script>
</body>
</html>
