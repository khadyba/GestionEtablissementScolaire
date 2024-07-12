<div class="container">
    <h1>Salles Disponibles pour la Classe {{ $classe->nom }}</h1>

    <table>
        <thead>
            <tr>
                <th>Numéro</th>
                <th>Capacité</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($salles as $salle)
                <tr>
                    <td>{{ $salle->numéro }}</td>
                    <td>{{ $salle->capaciter }}</td>
                    <td>
                        <form action="{{ route('professeurs.cours.assignSalle', ['coursId' => $cours->id, 'salleId' => $salle->id]) }}" method="POST">
                            @csrf
                            <button type="submit">Choisir cette salle</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('professeurs.cours.detail.prof', $cours->id) }}">Retourner au detail du cours</a>

</div>
