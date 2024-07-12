
    <h1>Ajouter une salle de classe</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.salles.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="numéro">Numéro de la salle :</label>
            <input type="number" name="numéro" id="numéro" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="capaciter">Capacité :</label>
            <input type="number" name="capaciter" id="capaciter" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="statut">Statut :</label>
            <select name="statut" id="statut" class="form-control" required>
                <option value="libre">Libre</option>
                <option value="occupe">Occupé</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Ajouter la salle de classe</button>
    </form>

