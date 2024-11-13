
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/canvas.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Link to external CSS file -->
    <!-- <link rel="stylesheet" href="{{ asset('assets/css/admin-dashboard.css') }}"> -->
</head>
@include('layouts.nav')
<body>
<div class="container">
    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    <div class="container  text-secondary">
        <h1 class="my-4">Liste des Élèves Inscrits</h1>

        @if (session('identifiants'))
        <div class="alert alert-info">
            <strong>Identifiants de connexion :</strong><br>
            Email : {{ session('identifiants.email') }}<br>
            Mot de passe : {{ session('identifiants.password') }}
        </div>
        @endif
        <table class="table table-striped">
    <thead class="table-primary">
        <tr>
            <th>Nom</th>
            <th>Prénoms</th>
            <th>Montant Payé</th>
            <th>Date de Paiement</th>
            <th>Type d'Établissement</th>
        </tr>
    </thead>
    <tbody>
        @if ($elevesInscrits->isNotEmpty())
            @foreach ($elevesInscrits->groupBy('eleve_id') as $eleveId => $paiementsGroupes)
                @php
                    $eleve = $paiementsGroupes->first()->eleve;
                    $etablissement = $eleve->user->etablissement;
                    $etablissementType = $etablissement ? $etablissement->type : 'Inconnu';

                    // On vérifie si l'établissement est privé ou public
                    $isPrivate = $etablissementType === 'privé';
                @endphp

                @if ($isPrivate)
                    <!-- Si l'établissement est privé, afficher toutes les inscriptions -->
                    @foreach($paiementsGroupes as $paiement)
                        <tr class="{{ $loop->index % 2 == 0 ? 'table-light' : 'table-dark' }}">
                            <td>{{ $paiement->eleve->nom }}</td>
                            <td>{{ $paiement->eleve->prenoms }}</td>
                            <td>{{ $paiement->montant }}</td>
                            <td>{{ $paiement->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $etablissementType }}</td>
                        </tr>
                    @endforeach
                @else
                    <!-- Si l'établissement est public, afficher une seule inscription -->
                    <tr class="{{ $loop->index % 2 == 0 ? 'table-light' : 'table-dark' }}">
                        <td>{{ $paiementsGroupes->first()->eleve->nom }}</td>
                        <td>{{ $paiementsGroupes->first()->eleve->prenoms }}</td>
                        <td>{{ $paiementsGroupes->first()->montant }}</td>
                        <td>{{ $paiementsGroupes->first()->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $etablissementType }}</td>
                    </tr>
                    @break <!-- Sortir de la boucle car on affiche une seule inscription -->
                @endif
            @endforeach
        @else
            <tr>
                <td colspan="5">Aucun élève inscrit</td>
            </tr>
        @endif
    </tbody>
</table>




  


        <div class="mt-4 ">
            <a href="{{ route('etablissement.formulaire') }}" class="btn btn-primary me-2">Ajouter un Etablissement</a>
            <a href="{{ route('classes.create') }}" class="btn btn-primary me-2">Ajouter une classe</a>
            <a href="{{ route('affiche.formulaire') }}" class="btn btn-primary me-2">Ajouter Professeurs</a>
            <a href="{{ route('classes.index') }}" class="btn btn-primary me-2">Voir la liste des classes</a>
            <a href="{{ route('admin.salles.create') }}" class="btn btn-primary me-2">Ajouter Salle de classe</a>
            <a href="{{ route('admin.salles-de-classe.index') }}" class="btn btn-primary me-2">liste Salles</a>

        </div>
    </div>

    <div class="container mt-4">
        <h1 class="my-4 text-secondary">Liste des Emplois du Temps</h1>
        <table class="table table-striped">
            <thead class="table-primary">
                <tr>
                    <th>Nom du Fichier</th>
                    <th>Classe</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @if ($emploisDuTemps->isNotEmpty())
                @foreach($emploisDuTemps as $emploiDuTemps)
                <tr class="{{ $loop->index % 2 == 0 ? 'table-light' : 'table-dark' }}">
                    <td>{{ $emploiDuTemps->nom_original }}</td>
                    <td>{{ $emploiDuTemps->classe->nom }}</td>

                    <td>
                        <a href="{{ route('emplois_du_temps.download', $emploiDuTemps->id) }}" class="btn btn-primary btn-sm">Télécharger</a>
                    </td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="2">Aucun emploi du temps disponible</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-8q3M7+Nyk3h71+Jld7oVk3Bq5LM5UBM2Zof2bl6cf1hUVOy6tGJ+6uoyfxg4S2yE" crossorigin="anonymous"></script>
</body>
</html>
