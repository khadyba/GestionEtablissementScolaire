
<div class="container">
<td><a href="{{ route('professeurs.prof.dashboard') }}">Retour à votre espace personnel</a></td>

    <h1>Liste de vos Notes</h1>

    <table class="table">
        <thead>
            <tr>
                <th>Élève</th>
                <th>Évaluation</th>
                <th>Note</th>
                <th>Appréciations</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($notes as $note)
                <tr>
                    <td>{{ $note->eleve->prenoms }}  {{ $note->eleve->nom }}</td>
                    <td>{{ $note->evaluation->titre }}</td>
                    <td>{{ $note->valeur }}</td>
                    <td>{{ $note->appreciations }}</td>
                    <td>
                        <a href="{{ route('professeurs.notes.edit', $note->id) }}" class="btn btn-primary">Modifier</a>
                        <form action="{{ route('professeurs.notes.delete', $note->id) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette note ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

