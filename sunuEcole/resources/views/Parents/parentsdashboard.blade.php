<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Parent</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/canvas.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    @include('partials.navPar') 

    <div class="container mt-5 text-secondary">
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <h1 class="mb-4">Espace Parent</h1>
        
        <div class="row">
            <!-- Colonne pour le formulaire -->
            <div class="col-md-6">
                <form action="{{ route('parents.eleves.notes') }}" method="GET" class="mb-4">
                    @csrf
                    <div class="mb-3">
                        <input type="text" name="non_de_votre_éléve" placeholder="Nom de famille de l'élève" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Afficher les notes</button>
                </form>

                <a href="{{ route('parents.parent.payInscription') }}" class="btn btn-primary">Payer l'inscription</a>
            </div>

            <!-- Colonne pour l'image -->
            <div class="col-md-6">
                <img src="{{ asset('assets/img/parent.jpg') }}" alt="Image Description" class="img-fluid">
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-4dUosZBzLv6/jYbbXsYrgg4QyVj2/j4vKMC/kpBlh24o3w2L1gmbv2JWo1IoewNn" crossorigin="anonymous"></script>
</body>
</html>
