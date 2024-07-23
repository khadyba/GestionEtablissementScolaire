<!DOCTYPE html>
<html>
<head>
    <title>Notes et Emploi du Temps</title>
</head>
<body>
<h1>Informations de {{ $eleve->prenoms }} {{ $eleve->nom }}</h1>

<h2>Notes</h2>
<table>
    <tr>
        <th>Évaluation</th>
        <th>Note</th>
        <th>Appréciation</th>
    </tr>
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
</table>

<h2>Emploi du Temps</h2>
@if ($emploiDuTemps)
    <p><a href="{{ Storage::url($emploiDuTemps->emplois_du_temps) }}" target="_blank">Télécharger l'emploi du temps</a></p>
@else
    <p>Aucun emploi du temps disponible pour cette classe.</p>
@endif

<button onclick="window.history.back()">Retour</button>
</body>
</html>
