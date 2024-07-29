<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier la Classe</title>
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
            <h1 class="mb-4">Modifier la Classe</h1>

            @if (session('success'))
                <div class="alert alert-success mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('classes.update', $classe->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group mb-3">
                    <label for="nom">Nom de la classe :</label>
                    <input type="text" name="nom" id="nom" class="form-control" value="{{ $classe->nom }}" required>
                    @error('nom')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="niveau">Niveau :</label>
                    <input type="text" name="niveau" id="niveau" class="form-control" value="{{ $classe->niveau }}" required>
                    @error('niveau')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Mettre à jour</button>
            </form>
        </div>
        <div class="col-md-6 d-flex justify-content-center align-items-center">
            <img src="{{ asset('assets/img/image.jpeg') }}" alt="Image description" class="img-fluid">
        </div>
    </div>
</div>
</body>
</html>
