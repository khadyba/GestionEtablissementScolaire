
<!DOCTYPE html>
<html>
<head>
    <title>Liste des Notes</title>
</head>
<body>
    <div class="container">
<td><a href="{{ route('professeurs.prof.dashboard') }}">Retour à votre espace personnel</a></td>

        <h1>Liste des Notes</h1>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table>
            <tr>
                <th>Élève</th>
                <th>Évaluation</th>
                <th>Note</th>
                <th>Appréciations</th>
                <th>coefficient</th>
                <th>Actions</th>
            </tr>
            
            @foreach ($notes as $note)
            <tr>
                <td>{{ $note->eleve->prenoms }} {{ $note->eleve->nom }}</td>
                <td>{{ $note->evaluation->type }}</td>
                <td>{{ $note->valeur }}</td>
                <td>{{ $note->appreciations }}</td>
                <td>{{ $note->coefficient }}</td>

                <td>
                    <a href="{{ route('professeurs.notes.edit', $note->id) }}">Modifier</a>
                    <form action="{{ route('professeurs.notes.delete', $note->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Supprimer</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</body>
</html>
















   