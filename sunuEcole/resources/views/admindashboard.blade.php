<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <!-- Ajoutez les liens vers les fichiers CSS nécessaires -->
</head>
<body>

    <form action="{{ route('admin.logout') }}" method="POST" style="display:inline">
        @csrf
        <button type="submit" class="btn btn-danger">Déconnexion</button>
    </form>
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
    <div class="container">
        <h1>Liste des Élèves Inscrits</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénoms</th>
                    <th>Montant Payé</th>
                    <th>Date de Paiement</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($elevesInscrits->isNotEmpty())
                    @foreach($elevesInscrits as $paiement)
                        <tr>
                            <td>{{ $paiement->eleve->nom }}</td>
                            <td>{{ $paiement->eleve->prenoms }}</td>
                            <td>{{ $paiement->montant }}</td>
                            <td>{{ $paiement->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <a href="{{ route('classes.assign.students', $paiement->eleve->id) }}" class="btn btn-primary">Affecter à une Classe</a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5">Aucun élève inscrit</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <div>
            <a href="{{ route('etablissement.formulaire') }}" class="btn btn-primary">Ajouter un Etablissement</a>
            <a href="{{ route('classes.create') }}">Ajouter une classe</a>
            <a href="{{ route('affiche.formulaire') }}">Ajouter Professeurs</a>
            <a href="{{ route('classes.index') }}">Voir la liste des classes</a>
            @if ($classeId)
                <a href="{{ route('emplois_du_temps.create', $classeId) }}">Importer un emploi du Temps</a>
            @endif
        </div>
    </div>

    <div class="container-2" style="display:inline">
        <h1>Liste des Emplois du Temps</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Nom du Fichier</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @if ($emploisDuTemps->isNotEmpty())
                    @foreach($emploisDuTemps as $emploiDuTemps)
                        <tr>
                            <td>{{ basename($emploiDuTemps->emplois_du_temps) }}</td>
                            <td>
                                <a href="{{ route('emplois_du_temps.download', $emploiDuTemps->id) }}" class="btn btn-primary">Télécharger</a>
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
</body>
</html>
