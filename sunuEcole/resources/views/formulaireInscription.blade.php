<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Inscription</title>
<link rel="icon" type="image/png" href="{{ asset('assets/img/canvas.png') }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <div class="mt-3 mb-4">
        <img src="{{ asset('assets/img/canvas.png') }}" alt="Sunulyce Logo">
    </div>
    <div class="row mt-5 ">
        <div class="col-md-6">
            <div class="mb-3">
                <h1>Formulaire d'inscription</h1>
            </div>
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
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email :</label>
                    <input type="email" id="email" class="form-control" name="email" value="{{ old('email') }}" aria-describedby="emailHelp" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Mot de passe :</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="typecompte" class="form-label">Type de compte :</label>
                    <select id="typecompte" name="typecompte" class="form-select" required>
                        <option value="professeurs">Professeur</option>
                        <option value="eleves">Élève</option>
                        <option value="parents">Parent</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="etablissement_id" class="form-label">Établissement :</label>
                    <select id="etablissement_id" name="etablissement_id" class="form-select" required>
                        <option value=""></option>
                        @foreach($etablissements as $etablissement)
                            <option value="{{ $etablissement->id }}">{{ $etablissement->nom }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary mb-3">S'inscrire</button>
            </form>
        </div>
        <div class="col-md-6 mt-5">
            <img src="{{ asset('assets/img/create-account-office.jpeg') }}" alt="Image description" class="img-fluid">
        </div>
    </div>
</div>
</body>
</html>
