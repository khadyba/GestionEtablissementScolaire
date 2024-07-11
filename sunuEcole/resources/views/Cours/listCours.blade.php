<td><a href="{{ route('prof.dashboard') }}">Retour a votre espace personnel</a></td>

<<h1>Liste des Cours</h1>
<table>
    <thead>
        <tr>
            <th>Titre</th>
            <th>Description</th>
            <th>Professeur</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($cours as $coursItem)
            <tr>
                <td>{{ $coursItem->titre }}</td>
                <td>{{ $coursItem->descriptions }}</td>
                <td>
                    @if ($coursItem->professeur)
                        {{ $coursItem->professeur->prenoms }} {{ $coursItem->professeur->nom }}  
                    @else
                        Aucun professeur assigné
                    @endif
                </td>
                <td>
                    <a href="{{ route('professeurs.cours.detail.prof', $coursItem->id) }}">Voir détails</a>
                    @if ($coursItem->professeur_id == auth()->user()->professeur->id)
                        <a href="{{ route('professeurs.cours.edit', $coursItem->id) }}">Modifier</a>
                        <form action="{{ route('professeurs.cours.destroy', $coursItem->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Supprimer</button>
                        </form>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>



















