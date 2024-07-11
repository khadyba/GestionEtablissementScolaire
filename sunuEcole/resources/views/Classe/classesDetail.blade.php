

@section('content')
<div class="container">
    <h1>Classe: {{ $classe->nom }}</h1>
    <p>Niveau: {{ $classe->niveau }}</p>
    <p>Établissement: {{ $classe->etablissement->nom }}</p>

    <h2>Élèves assignés</h2>
    <ul>
        @if ($classe->eleves->isNotEmpty())
            @foreach($classe->eleves as $eleve)
                <li>{{ $eleve->prenoms }} {{ $eleve->nom }}</li>
            @endforeach
        @else
            <li>Aucun élève assigné</li>
        @endif
    </ul>
    <h2>Professeurs assignés :</h2>
    <ul>
    @if ($classe->professeurs->isNotEmpty())
          @foreach($classe->professeurs as $professeur)
            <li>{{ $professeur->prenoms }} {{ $professeur->nom }} - {{ $professeur->spécialiter }}</li>
        @endforeach
        @else
        <li>Aucun professeur assigné</li>
        @endif
    </ul>
    <h2>Emploi du temps</h2>
    @if ($classe->emploisDuTemps->isNotEmpty())
        <ul>
            @foreach ($classe->emploisDuTemps as $emploiDuTemps)
                <li>
                    <a href="{{ Storage::url($emploiDuTemps->emplois_du_temps) }}" target="_blank">{{ $emploiDuTemps->nom_original }}</a>
                </li>
            @endforeach
        </ul>
    @else
        <p>Aucun emploi du temps disponible pour cette classe.</p>
    @endif
          
    <a href="{{ route('professeurs.cours.list.prof') }}" class="btn btn-primary">Voir la liste des Cours</a>
            

    <a href="{{ route('classes.index') }}" class="btn btn-primary">Retour à la liste des classes</a>
</div>

