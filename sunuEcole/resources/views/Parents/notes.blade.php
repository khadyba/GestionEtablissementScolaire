<!DOCTYPE html>
<html>
<head>
    <title>Notes de {{ $eleve->prenoms }} {{ $eleve->nom }}</title>
</head>
<body>
    <h1>Notes de {{ $eleve->prenoms }} {{ $eleve->nom }}</h1>

    @if ($notes->isEmpty())
        <p>Aucune note disponible.</p>
    @else
        <table border="1">
            <tr>
                <th>Évaluation</th>
                <th>Note</th>
                <th>Appréciation</th>
            </tr>
            @foreach ($notes as $note)
            <tr>
                <td>{{ $note->evaluation->titre }}</td>
                <td>{{ $note->valeur }}</td>
                <td>{{ $note->appreciations }}</td>
            </tr>
            @endforeach
        </table>
    @endif
    <a href="{{ route('parents.parent.dashboard') }}" class="btn btn-primary">Retour au Dashboard</a>
</body>
</html>

