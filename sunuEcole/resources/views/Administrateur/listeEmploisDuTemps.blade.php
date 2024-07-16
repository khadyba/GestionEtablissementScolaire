
    <div class="container">
        <h1>Liste des Emplois du Temps</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom du Fichier</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($emploisDuTemps as $emploiDuTemps)
                <tr>
                    <td>{{ $emploiDuTemps->id }}</td>
                    <td>{{ $emploiDuTemps->emplois_du_temps }}</td>
                    <td>
                      
                        <a href="{{ route('emplois_du_temps.download', $emploiDuTemps->id) }}" class="btn btn-primary">Télécharger</a>
                       
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

