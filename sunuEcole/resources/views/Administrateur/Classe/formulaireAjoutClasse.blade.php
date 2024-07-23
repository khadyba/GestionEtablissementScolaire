
    <div class="container">
        <h1>Ajouter une Classe</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('classes.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="nom">Nom de la classe :</label>
                <input type="text" name="nom" id="nom" class="form-control" value="{{ old('nom') }}" required>
                @error('nom')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="niveau">Niveau :</label>
                <input type="text" name="niveau" id="niveau" class="form-control" value="{{ old('niveau') }}" required>
                @error('niveau')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="etablissement_id">Établissement :</label>
                <select name="etablissement_id" id="etablissement_id" class="form-control" required>
                    @foreach ($etablissements as $etablissement)
                        <option value="{{ $etablissement->id }}">{{ $etablissement->nom }}</option>
                    @endforeach
                </select>
                @error('etablissement_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Ajouter</button>
        </form>
    </div>

