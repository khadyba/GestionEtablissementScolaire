<a href="{{ route('admin.dashboard') }}">Retour a votre espace personnel</a>


    <h1>Liste des Salles de Classe</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Numéro</th>
                <th>Capacité</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sallesDeClasse as $salle)
                <tr>
                    <td>{{ $salle->numéro }}</td>
                    <td>{{ $salle->capaciter }}</td>
                    <td>{{ $salle->statut }}</td>
                    <td>
                        <a href="{{ route('admin.salles-de-classe.edit', $salle->id) }}" class="btn btn-primary">Modifier</a>
                        <form action="{{ route('admin.salles-de-classe.destroy', $salle->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette salle de classe ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

