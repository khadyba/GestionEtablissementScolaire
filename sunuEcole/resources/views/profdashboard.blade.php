<form action="{{ route('users.logout') }}" method="POST" style="display:inline">
    @csrf
    <button type="submit" class="btn btn-danger">Déconnexion</button>
</form>

<h1>Liste des classes</h1>
<table>
    <thead>
        <tr>
            <th>Nom</th>
            <th>Niveau</th>
            <th>Établissement</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($classes as $classe)
            <tr>
                <td>{{ $classe->nom }}</td>
                <td>{{ $classe->niveau }}</td>
                <td>{{ $classe->etablissement->nom }}</td>
                <td>
                <a href="{{ route('professeurs.cours.create', $classe->id) }}"> Ajouter Cours </a>
                </td>
                <td>
                <a href="{{ route('professeurs.classes.show.prof', $classe->id) }}">Voir Detail</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
