
<!-- resources/views/uploadEmploiDuTemps.blade.php -->


<div class="container">
    <h1>Importer l'emploi du temps pour la classe {{ $classe->nom }}</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <form action="{{ route('emplois_du_temps.store', ['classe' => $classe->id]) }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="form-group">
        <label for="file">Sélectionner un fichier </label>
        <input type="file" name="file" id="file" class="form-control-file" required>
    </div>

    <button type="submit" class="btn btn-primary">Sélectionner</button>
</form>

</div>

