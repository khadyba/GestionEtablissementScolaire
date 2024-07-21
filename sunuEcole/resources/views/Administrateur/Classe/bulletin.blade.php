<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bulletin de Notes</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
        }
        .header, .footer {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
        }
        .header p {
            margin: 5px 0;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th, .table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        .table th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $classe->etablissement->nom }}</h1>
        <p>Adresse : {{ $classe->etablissement->adresse }}</p>
        <p>Téléphone : {{ $classe->etablissement->telephone }}</p>
        <p>Directeur : {{ $classe->etablissement->directeur }}</p>
    </div>

    <h2>Bulletin de Notes de {{ $eleve->prenoms }} {{ $eleve->nom }}</h2>

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
                    <td>{{ $note->evaluation->titre }}</td>
                    <td>{{ $note->valeur }}</td>
                    <td>{{ $note->coefficient }}</td>
                    <td>{{ $note->appreciations }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p> Moyenne : {{ $moyenne }}</p>
    </div>
</body>
</html>
