<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un nouveau cours</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/canvas.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
@include('partials.navProf')
<body>
<div class="container my-4">
    <div class="row">
        <div class="col-md-6">
            <h1 class="mb-4 text-secondary">Créer un nouveau cours</h1>
            @if ($errors->any())
                <div class="alert alert-danger mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('professeurs.cours.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group mb-3">
                    <label for="titre" class="text-secondary">Titre :</label>
                    <input type="text" name="titre" id="titre" class="form-control" value="{{ old('titre') }}" required>
                    @error('titre')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="descriptions" class="text-secondary">Description :</label>
                    <textarea name="descriptions" id="descriptions" class="form-control" required>{{ old('descriptions') }}</textarea>
                    @error('descriptions')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="jours" class="text-secondary">Jour :</label>
                    <input type="date" name="jours" id="jours" class="form-control" value="{{ old('jours') }}" required>
                    @error('jours')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="heure_debut" class="text-secondary">Heure de début :</label>
                    <input type="time" name="heure_debut" id="heure_debut" class="form-control" value="{{ old('heure_debut') }}" required>
                    @error('heure_debut')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="heure_fin" class="text-secondary">Heure de fin :</label>
                    <input type="time" name="heure_fin" id="heure_fin" class="form-control" value="{{ old('heure_fin') }}" required>
                    @error('heure_fin')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="fichier_cours" class="text-secondary">Fichier du cours :</label>
                    <input type="file" name="fichier_cours" id="fichier_cours" class="form-control" required>
                    @error('fichier_cours')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="classe_id" class="text-secondary">Sélectionner une classe :</label>
                    <select name="classe_id" id="classe_id" class="form-control" required>
                        <option value="{{ $classe->id }}">{{ $classe->nom }}</option>
                    </select>
                    @error('classe_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary" class="text-secondary">Créer</button>
            </form>
        </div>
        <div class="col-md-6 d-flex justify-content-center align-items-center ">
            <img src="{{ asset('assets/img/cour-edit.png') }}" alt="Image description" class="img-fluid">
        </div>
    </div>
</div>
</body>
</html>
