<form action="{{ route('users.logout') }}" method="POST" style="display:inline">
    @csrf
    <button type="submit" class="btn btn-danger">Déconnexion</button>
</form>
<h1>Liste des classes</h1>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('error')) <!-- Changer 'errors' en 'error' -->
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<table>
    <thead>
        <tr>
            <th>Nom</th>
            <th>Niveau</th>
            <th>Établissement</th>
        </tr>
    </thead>
    <tbody>
        @foreach($classes as $classe)
            <tr>
                <td>{{ $classe->nom }}</td>
                <td>{{ $classe->niveau }}</td>
                <td>{{ $classe->etablissement->nom }}</td>
                <td>
                    <a href="{{ route('classes.show', $classe->id) }}">Voir Details </a>
                    <a href="{{ route('professeurs.cours.list.prof', $classe->id) }}">Voir Cours</a>
                </td>
            </tr>
            
        @endforeach
    </tbody>
</table>
