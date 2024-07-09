
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

    <h2>Professeurs assignés</h2>
<ul>
    @if ($classe->professeurs->isNotEmpty())
        @foreach($classe->professeurs as $professeur)
            <li>{{ $professeur->prenoms }} {{ $professeur->nom }} - {{ $professeur->specialite }}</li>
        @endforeach
    @else
        <li>Aucun professeur assigné</li>
    @endif
</ul>


    <a href="{{ route('classes.index') }}" class="btn btn-primary">Retour à la liste des classes</a>
</div>
