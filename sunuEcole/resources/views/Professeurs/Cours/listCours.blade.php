
<div class="container">
    <td><a href="{{ route('professeurs.prof.dashboard') }}">Retour à votre espace personnel</a></td>

    <h1>Liste des Cours de la classe {{ $classe->nom }}</h1>

    @if ($cours->isEmpty())
        <p>Aucun cours ajouté pour cette classe.</p>
    @else
        <table class="table">
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
                                <form action="{{ route('professeurs.cours.destroy', $coursItem->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce cours ?')">Supprimer</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
