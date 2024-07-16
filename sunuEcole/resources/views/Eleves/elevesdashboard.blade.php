

<div class="container">
    <h1>Liste des Classes</h1>
    <ul>
        @foreach ($classes as $classe)
            <li>
                <a href="{{ route('eleves.classes.detail', ['id' => $classe->id]) }}">
                    {{ $classe->nom }}
                </a>
            </li>
        @endforeach
    </ul>

    <form action="{{ route('users.logout') }}" method="POST" style="display:inline">
    @csrf
    <button type="submit" class="btn btn-danger">Déconnexion</button>
</form>
    <div class="container">
    <a href="{{ route('eleves.eleves.payInscription') }}" class="btn btn-primary" target="_blank">Payer mon inscription</a>
</div>
</div>

