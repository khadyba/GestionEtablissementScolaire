<h1>Gérer les Professeurs pour la Classe {{ $classe->nom }}</h1>
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
        @foreach($professeurs as $professeur)
            <tr>
                <td>{{ $professeur->prenoms }} {{ $professeur->nom }} </td>
                <td>{{ $professeur->spécialiter }}</td>
                <td>
                    <form action="{{ route('classes.professeurs.detach', ['classeId' => $classe->id, 'professeurId' => $professeur->id]) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir retirer ce professeur de la classe ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Retirer</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
