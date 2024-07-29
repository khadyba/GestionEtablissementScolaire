<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Profil Administrateur</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/canvas.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
@include('layouts.nav')
<body>
<div class="container my-4">
    <div class="mt-3 mb-4">
        <img src="{{ asset('assets/img/canvas.png') }}" alt="Logo">
    </div>
    <div class="row">
        <div class="col-md-6">
            <h1 class="mb-4 text-secondary">Modifier le Profil</h1>

            @if (session('success'))
                <div class="alert alert-success mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('admin.profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group mb-3">
                    <label for="adresse">Adresse :</label>
                    <input type="text" id="adresse" name="adresse" class="form-control" value="{{ old('adresse', $admin->adresse) }}" required>
                    @error('adresse')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="telephone">Numéro de téléphone :</label>
                    <input type="text" id="telephone" name="telephone" class="form-control" value="{{ old('telephone', $admin->telephone) }}" required>
                    @error('telephone')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="email">Email :</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $admin->email) }}" required>
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Mettre à jour</button>
            </form>
        </div>
        <div class="col-md-4 d-flex justify-content-center align-items-center">
        <img src="{{ asset('assets/img/inscription-administrateur.jpg') }}" alt="Image description" class="img-fluid">

        </div>
    </div>
</div>
</body>
</html>
