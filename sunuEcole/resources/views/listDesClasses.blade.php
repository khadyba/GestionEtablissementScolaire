<h1>Liste des classes</h1>
<a href="{{ route('classes.create') }}">Ajouter une classe</a>
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
                    <a href="{{ route('classes.edit', $classe->id) }}">Modifier</a>
                    <form action="{{ route('classes.destroy', $classe->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Supprimer</button>
                    </form>
                    <a href="{{ route('classes.assign.students', $classe->id) }}">Affecter Élèves</a>
                    <a href="{{ route('classes.assign.teachers', $classe->id) }}">Affecter Professeurs a une classe</a>
                    <a href="{{ route('users.create') }}">Ajouter Professeurs</a>
                    <a href="{{ route('emplois_du_temps.create') }}">Ajouter Emplois du temps</a>


                </td>
            </tr>
        @endforeach
    </tbody>
</table>
