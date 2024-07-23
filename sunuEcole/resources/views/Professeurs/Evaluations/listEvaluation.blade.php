<div class="container">
<td><a href="{{ route('professeurs.prof.dashboard') }}">Retour à votre espace personnel</a></td>
    <h1>Évaluations pour la Classe {{ $classe->nom }}</h1>
    @if ($evaluations->isEmpty())
        <p>Aucune Evaluations Programmer pour le moment.</p>
    @else
    <table>
        <thead>
            <tr>
                <th>Titre</th>
                <th>Type</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($evaluations as $evaluation)
                <tr>
                    <td>{{ $evaluation->titre }}</td>
                    <td>{{ $evaluation->type }}</td>
                    <td>{{ $evaluation->jours }}</td>
                    
                   <td> <a href="{{ route('professeurs.evaluations.add_notes', ['classeId' => $classe->id, 'evaluationId' => $evaluation->id]) }}">Ajouter des Notes</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
        <a href="{{ route('professeurs.evaluations.create', $classe->id) }}">Programmer une évaluation</a>

    </div>

