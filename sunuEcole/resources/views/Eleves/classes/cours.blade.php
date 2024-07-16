
<div class="container">
<h1>Liste des Cours pour la Classe {{ $classe->nom }}</h1>
    @if ($cours->isNotEmpty())
        <ul>
            @foreach ($cours as $cour)
                <li>
                    <a href="{{ route('eleves.cours.detail', ['id' => $cour->id]) }}">
                        {{ $cour->titre }}
                    </a>
                </li>
            @endforeach
        </ul>
    @else
        <p>Aucun cours disponible pour cette classe.</p>
    @endif
    <a href="{{ route('eleves.eleve.dashboard') }}" class="btn btn-primary">Retour à votre espace personnel</a>
</div>


