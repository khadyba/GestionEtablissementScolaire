<h1>Gérer les Eleves pour la Classe {{ $classe->nom }}</h1>
<a href="{{ route('classes.show', $classe->id) }}" class="btn btn-primary">Retourner à la Classe</a>

<table>
    <thead>
        <tr>
            <th>Nom</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($eleves as $eleve)
            <tr>
                <td>{{ $eleve->prenoms }} {{ $eleve->nom }} </td>
                <td>
                    <form action="{{ route('classes.eleve.detach', ['classeId' => $classe->id, 'eleveId' =>  $eleve->id]) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir retirer cette éleves de la classe ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Retirer</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
