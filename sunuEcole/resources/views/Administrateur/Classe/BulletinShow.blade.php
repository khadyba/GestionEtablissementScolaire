<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bulletin de Notes</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> 
</head>
<body>
    <div class="container">
        <header>
            <h1>{{ $etablissement->nom }}</h1>
            <p>Adresse : {{ $etablissement->adresse }}</p>
            <p>Téléphone : {{ $etablissement->telephone }}</p>
            <p>Directeur : {{ $etablissement->directeur }}</p>
        </header>
        
        <h2>Bulletin de Notes de {{ $eleve->prenoms }} {{ $eleve->nom }}</h2>
        
        <table class="table">
            <thead>
                <tr>
                    <th>Matiére</th>
                    <th>Note</th>
                    <th>Coefficient</th>
                    <th>Appréciations</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($eleve->notes as $note)
                    <tr>
                        <td>{{ $note->evaluation->titre }} {{ $note->evaluation->type }} </td>
                        <td>{{ $note->valeur }}</td>
                        <td>{{ $note->coefficient }}</td>
                        <td>{{ $note->appreciations }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="footer">
            <p>Moyenne : {{ $moyenne }}</p>
        </div>
    </div>
    <button onclick="window.history.back()">Retour</button>
</body>
</html>
