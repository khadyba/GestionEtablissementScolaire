<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Importer l'Emploi du Temps</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/canvas.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>
@include('layouts.nav')

<body>
<div class="container my-4">
       <div class="mt-3 mb-4">
        <img src="{{ asset('assets/img/canvas.png') }}" alt="Sunulyce Logo">
        </div>
    <div class="row">
        <div class="col-md-6">
            <h1 class="mb-4">Importer l'emploi du temps pour la classe {{ $classe->nom }}</h1>
            @if ($errors->any())
                <div class="alert alert-danger mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('emplois_du_temps.store', ['classe' => $classe->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group mb-3">
                    <label for="emplois_du_temps">Sélectionner un fichier :</label>
                    <input type="file" name="emplois_du_temps" id="emplois_du_temps" class="form-control-file" required>
                </div>
                <button type="submit" class="btn btn-primary">Importer</button>
            </form>
        </div>

        <div class="col-md-6 d-flex justify-content-center align-items-center">
        <img src="{{ asset('assets/img/emplois-du-temps.jpg') }}" alt="Image description" class="img-fluid ">
        </div>
    </div>
</div>


</body>
</html>
