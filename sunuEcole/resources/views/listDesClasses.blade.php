<h1>Liste des classes</h1>
<a href="{{ route('classes.create') }}">Ajouter une classe</a>
<form action="{{ route('admin.logout') }}" method="POST" style="display:inline">
    @csrf
    <button type="submit" class="btn btn-danger">Déconnexion</button>
</form>
<table>
    <thead>
        <tr>
            <th>Nom</th>
            <th>Niveau</th>
            <th>Établissement</th>
            <th>Professeur assigné</th>
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
                    @if ($classe->professeurs->isNotEmpty())
                        {{ $classe->professeurs->first()->prenoms }} {{ $classe->professeurs->first()->nom }}
                    @else
                        Aucun professeur assigné
                    @endif
                </td>
                <td>
                    <a href="{{ route('classes.edit', $classe->id) }}">Modifier</a>
                    <form action="{{ route('classes.destroy', $classe->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Supprimer</button>
                    </form>
                    <a href="{{ route('classes.assign.students', $classe->id) }}">Affecter Élèves</a>
                    <a href="{{ route('classes.assign.teachers', $classe->id) }}">Affecter Professeurs</a>
                    <a href="{{ route('affiche.formulaire') }}">Ajouter Professeurs</a>
                    <a href="{{ route('emplois_du_temps.create') }}">Ajouter Emplois du temps</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
