<div class="container">
<form action="{{ route('users.logout') }}" method="POST" style="display:inline">
        @csrf
        <button type="submit" class="btn btn-danger">Déconnexion</button>
    </form>
    <h1>Liste des Classes</h1>
    <ul>
        @foreach ($classes as $classe)
            <li>
                <a href="{{ route('eleves.classes.detail', ['id' => $classe->id]) }}">
                    {{ $classe->nom }}
                </a>
                <a href="{{ route('eleves.evaluations.list', ['classe' => $classe->id]) }}" class="btn btn-info">Voir les Évaluations</a>
            </li>
        @endforeach
    </ul>
    <div class="container">
        <a href="{{ route('eleves.eleves.payInscription') }}" class="btn btn-primary" target="_blank">Payer mon inscription</a>
        <a href="{{ route('eleves.notes.list') }}" class="btn btn-primary">Consulter mes Notes</a>
    </div>
</div>
