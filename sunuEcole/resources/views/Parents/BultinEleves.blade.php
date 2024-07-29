<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bulletin de Notes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/canvas.png') }}">
</head>
@include('partials.navPar')

<body>
    <div class="container my-4">
        <header class="mb-4">
            <h1 class="mb-2">{{ $etablissement->nom }}</h1>
            <p>Adresse : {{ $etablissement->adresse }}</p>
            <p>Téléphone : {{ $etablissement->telephone }}</p>
            <p>Directeur : {{ $etablissement->directeur }}</p>
        </header>
        
        <h2 class="mb-4">Bulletin de Notes de {{ $eleve->prenoms }} {{ $eleve->nom }}</h2>
        
        <table class="table table-bordered">
            <thead class="table-primary">
                <tr>
                    <th>Matière</th>
                    <th>Note</th>
                    <th>Coefficient</th>
                    <th>Appréciations</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($eleve->notes as $note)
                    <tr>
                        <td>{{ $note->evaluation->titre }} {{ $note->evaluation->type }}</td>
                        <td>{{ $note->valeur }}</td>
                        <td>{{ $note->coefficient }}</td>
                        <td>{{ $note->appreciations }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="mt-4">
            <p><strong>Moyenne :</strong> {{ $moyenne }}</p>
        </div>
    </div>
    <div class="container text-center mt-4">
        <button onclick="window.history.back()" class="btn btn-light">Retour</button>
    </div>
</body>
</html>
