<div class="container">
    <h1>Mes Notes</h1>
    @if ($notes->isEmpty())
        <p>Vous n'avez aucune note pour le moment.</p>
    @else
        <table>
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
                        <td>{{ $note->semestre }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    <a href="{{ route('eleves.eleve.dashboard') }}" class="btn btn-primary">Retour au Dashboard</a>
</div>
