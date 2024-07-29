<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notes et Emploi du Temps</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/canvas.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    @include('partials.navElv')
    <div class="container my-4 text-secondary">
        <h1 class="mb-4">Informations de {{ $eleve->prenoms }} {{ $eleve->nom }}</h1>

        <div class="row">
            <!-- Colonne pour les Notes -->
            <div class="col-md-8">
                <h2>Notes</h2>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Évaluation</th>
                                <th>Note</th>
                                <th>Appréciation</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($notes && $notes->count() > 0)
                                @foreach ($notes as $note)
                                    <tr>
                                        <td>{{ $note->evaluation->titre }}</td>
                                        <td>{{ $note->valeur }}</td>
                                        <td>{{ $note->appreciations }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="3">Aucune note pour cet élève.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Colonne pour l'Emploi du Temps -->
            <div class="col-md-4">
                <h2>Emploi du Temps</h2>
                @if ($emploiDuTemps)
                    <p><a href="{{ Storage::url($emploiDuTemps->emplois_du_temps) }}" class="btn btn-primary" target="_blank">Télécharger l'emploi du temps</a></p>
                @else
                    <p>Aucun emploi du temps disponible pour cette classe.</p>
                @endif
            </div>
        </div>
        <div class="container text-center mt-4">
            <button onclick="window.history.back()" class="btn btn-secondary">Retour</button>
        <a href="{{ route('parents.eleves.bulletin', [$classe->id, $eleve->id]) }}" class="btn btn-secondary">Voir le Bulletin</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-4dUosZBzLv6/jYbbXsYrgg4QyVj2/j4vKMC/kpBlh24o3w2L1gmbv2JWo1IoewNn" crossorigin="anonymous"></script>
</body>
</html>
