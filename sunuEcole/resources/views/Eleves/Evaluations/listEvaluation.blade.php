<div class="container">
    <h1>Évaluations programmées pour la Classe {{ $classe->nom }}</h1>
    @if ($evaluations->isEmpty())
        <p>Aucune évaluation programmée pour le moment.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Type</th>
                    <th>Date</th>
                    <th>Heure de début</th>
                    <th>Heure de fin</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($evaluations as $evaluation)
                    <tr>
                        <td>{{ $evaluation->titre }}</td>
                        <td>{{ $evaluation->type }}</td>
                        <td>{{ $evaluation->jours }}</td>
                        <td>{{ $evaluation->heure_debut }}</td>
                        <td>{{ $evaluation->heure_fin }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    <a href="{{ route('eleves.eleve.dashboard') }}" class="btn btn-primary">Retour au Dashboard</a>
</div>
