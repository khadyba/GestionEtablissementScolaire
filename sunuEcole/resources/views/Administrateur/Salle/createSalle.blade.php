<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une Salle de Classe</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/canvas.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<div class="container my-4">
    <div class="mt-3 mb-4">
        <img src="{{ asset('assets/img/canvas.png') }}" alt="Sunulyce Logo">
        </div>
    <div class="row">
        <!-- Formulaire dans une colonne -->
        <div class="col-md-6">
            <h1 class="mb-4">Ajouter une Salle de Classe</h1>

            @if ($errors->any())
                <div class="alert alert-danger mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.salles.store') }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="numéro">Numéro de la salle :</label>
                    <input type="number" name="numéro" id="numéro" class="form-control" placeholder="Entrez le numéro de la salle" required>
                </div>
                <div class="form-group mb-3">
                    <label for="capaciter">Capacité :</label>
                    <input type="number" name="capaciter" id="capaciter" class="form-control" placeholder="Entrez la capacité de la salle" required>
                </div>
                <div class="form-group mb-3">
                    <label for="statut">Statut :</label>
                    <select name="statut" id="statut" class="form-control" required>
                        <option value="" disabled selected>Choisissez un statut</option>
                        <option value="libre">Libre</option>
                        <option value="occupe">Occupé</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Ajouter la salle de classe</button>
            </form>
        </div>

        <!-- Colonne pour l'image -->
        <div class="col-md-6 d-flex justify-content-center align-items-center">
        <img src="{{ asset('assets/img/classe.jpg') }}" alt="Image description" class="img-fluid ">
        </div>
    </div>
</div>


</body>
</html>
