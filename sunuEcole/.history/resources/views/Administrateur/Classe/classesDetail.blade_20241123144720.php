<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détail Classe</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/canvas.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
@include('layouts.nav')

<div class="container">
    <div class="row align-items-center mb-4">
        <div class="col-md-10 ">
            <h1 class="text-secondary" >Classe: {{ $classe->nom }}</h1>
            <p class="text-secondary">Niveau: {{ $classe->niveau }}</p>
        </div>
        <div class="col-md-2 text-end">
            <img src="{{ asset('assets/img/canvas.png') }}" alt="Sunulyce Logo" class="img-fluid" style="max-height: 50px;">
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <h2 class="text-secondary">Élèves assignés</h2>
            <ul class="list-group">
                @if ($classe->eleve->isNotEmpty())
                    @foreach($classe->eleve as $eleves)
                        <li class="list-group-item list-group-item-primary">{{ $eleves->prenoms }} {{ $eleves->nom }}</li>
                    @endforeach
                @else
                    <li class="list-group-item list-group-item-warning">Aucun élève assigné</li>
                @endif
            </ul>

            <h2 class="text-secondary">Professeurs assignés</h2>
            <ul class="list-group">
                @if ($classe->professeurs->isNotEmpty())
                    @foreach($classe->professeurs as $professeur)
                        <li class="list-group-item list-group-item-secondary">{{ $professeur->prenoms }} {{ $professeur->nom }} - {{ $professeur->spécialiter }}</li>
                    @endforeach
                @else
                    <li class="list-group-item list-group-item-warning">Aucun professeur assigné</li>
                @endif
            </ul>

            <h2 class="text-secondary">Emploi du temps</h2>
            @if ($classe->emploisDuTemps->isNotEmpty())
                <ul class="list-group">
                    @foreach ($classe->emploisDuTemps as $emploiDuTemps)
                        <li class="list-group-item list-group-item-info">
                            <a href="{{ Storage::url($emploiDuTemps->emplois_du_temps) }}" target="_blank">{{ $emploiDuTemps->nom_original }}</a>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="list-group-item list-group-item-danger">Aucun emploi du temps disponible pour cette classe.</p>
            @endif
        </div>


        <div class="col-md-6 d-flex justify-content-center align-items-center">
            <img src="{{ asset('assets/img/ouverture.jpg') }}" alt="Image description" class="img-fluid">
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('list', $classe->id) }}" class="btn btn-primary">Voir la liste des Cours</a>
        <a href="{{ route('classes.notes', $classe->id) }}" class="btn btn-primary">Calcul des moyennes</a>
        <a href="{{ route('classes.index') }}" class="btn btn-primary">Retour à la liste des classes</a>
    </div>
    
</div>

</body>
</html>
