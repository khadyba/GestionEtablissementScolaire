<!DOCTYPE html>
<html>
<head>
    <title>Emploi du Temps</title>
</head>
<body>
    <p>Bonjour,</p>
    <p>Vous trouverez ci-dessous l'emploi du temps de votre enfant {{ $eleve->prenoms }} {{ $eleve->nom }}.</p>
    <a href="{{ route('parents.eleves.emploi_du_temps', ['eleve' => $eleve->id]) }}">Voir l'emploi du temps</a>
</body>
</html>
