<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Notes</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/canvas.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    @include('partials.navElv')

    <div class="container my-4">
        <h1 class="mb-4 text-secondary">Mes Notes</h1>
        <div class="row">
          
            <!-- Colonne pour le tableau -->
            <div class="col-md-8">
                @if ($notes->isEmpty())
                    <p>Vous n'avez aucune note pour le moment.</p>
                @else
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Évaluation</th>
                                <th>Note</th>
                                <th>Appréciations</th>
                            
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($notes as $note)
                                <tr>
                                    <td>{{ $note->evaluation->titre }}</td>
                                    <td>{{ $note->valeur }}</td>
                                    <td>{{ $note->appreciations }}</td>
                                  
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
            <!-- Colonne pour l'image -->
            <div class="col-md-4 mb-4">
                  <img src="{{ asset('assets/img/note.png') }}" alt="Description de l'image" class="img-fluid">
              </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-4dUosZBzLv6/jYbbXsYrgg4QyVj2/j4vKMC/kpBlh24o3w2L1gmbv2JWo1IoewNn" crossorigin="anonymous"></script>
    <div class="container text-center mt-4">
        <button onclick="window.history.back()" class="btn btn-primary">Retour</button>
    </div>
</body>
</html>
