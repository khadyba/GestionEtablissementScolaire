


<div class="container">
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
    <h1>Notes pour la Classe {{ $classe->nom }}</h1>
    @foreach ($classe->eleve as $eleve)
        <h3>{{ $eleve->prenoms }} {{ $eleve->nom }}</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Évaluation</th>
                    <th>Note</th>
                    <th>Coefficient</th>
                    <th>Appréciations</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($eleve->notes as $note)
                    <tr>
                        <td>{{ $note->evaluation->type }} {{ $note->evaluation->titre }}</td>
                        <td>{{ $note->valeur }}</td>
                        <td>{{ $note->coefficient }}</td>
                        <td>{{ $note->appreciations }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <a href="{{ route('eleves.calculer_moyenne', [$eleve->id]) }}" class="btn btn-primary">Calculer la Moyenne</a>
        <a href="{{ route('eleves.bulletin', [$classe->id, $eleve->id]) }}" class="btn btn-secondary">Générer le Bulletin</a>
        <a href="{{ route('classes.bulletin', [$classe->id, $eleve->id]) }}" class="btn btn-secondary">Voir le bulletin</a>

    @endforeach
    
</div>
<button onclick="window.history.back()">Retour</button>

