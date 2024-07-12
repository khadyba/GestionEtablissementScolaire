
    <h1>Modifier la Salle de Classe</h1>

    <form action="{{ route('admin.salles-de-classe.update', $salle->id) }}" method="POST">
        @csrf
        @method('POST')

        <div class="form-group">
            <label for="numéro">Numéro :</label>
            <input type="text" name="numéro" id="numéro" class="form-control" value="{{ $salle->numéro }}" required>
        </div>

        <div class="form-group">
            <label for="capaciter">Capacité :</label>
            <input type="text" name="capaciter" id="capaciter" class="form-control" value="{{ $salle->capaciter }}" required>
        </div>

        <div class="form-group">
            <label for="statut">Statut :</label>
            <select name="statut" id="statut" class="form-control" required>
                <option value="libre" {{ $salle->statut == 'libre' ? 'selected' : '' }}>Libre</option>
                <option value="occupée" {{ $salle->statut == 'occupée' ? 'selected' : '' }}>Occupé</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
