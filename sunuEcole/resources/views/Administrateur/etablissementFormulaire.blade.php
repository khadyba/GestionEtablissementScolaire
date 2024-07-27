<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer Établissement</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/canvas.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<div class="container my-4">
    <div class="mt-3 mb-4">
        <img src="{{ asset('assets/img/canvas.png') }}" alt="Logo">
    </div>
    <div class="row">
        <div class="col-md-6">
            <h1 class="mb-4">Créer Établissement</h1>

            @if ($errors->any())
                <div class="alert alert-danger mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('etablissements.store') }}" method="POST">
                @csrf

                <div class="form-group mb-3">
                    <label for="nom">Nom :</label>
                    <input type="text" id="nom" name="nom" class="form-control" value="{{ old('nom') }}" required>
                    @error('nom')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="directeur">Directeur :</label>
                    <input type="text" id="directeur" name="directeur" class="form-control" value="{{ old('directeur') }}" required>
                    @error('directeur')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="adresse">Adresse :</label>
                    <input type="text" id="adresse" name="adresse" class="form-control" value="{{ old('adresse') }}" required>
                    @error('adresse')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="telephone">Téléphone :</label>
                    <input type="text" id="telephone" name="telephone" class="form-control" value="{{ old('telephone') }}" required>
                    @error('telephone')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="email">Email :</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="type">Type :</label>
                    <select id="type" name="type" class="form-control" required>
                        <option value="" disabled selected>Choisissez un type</option>
                        <option value="privé">Privé</option>
                        <option value="public">Public</option>
                    </select>
                    @error('type')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Créer Établissement</button>
            </form>
        </div>
        <div class="col-md-6 d-flex justify-content-center ">
            <img src="{{ asset('assets/img/ecole.jpg') }}" alt="Image description" class="img-fluid">
        </div>
    </div>
</div>
</body>
</html>
