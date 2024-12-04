<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Completer profile</title>
<link rel="icon" type="image/png" href="{{ asset('assets/img/canvas.png') }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
@include('layouts.nav')

<body>
<div class="container">
        <div class="mt-3 mb-4">
        <img src="{{ asset('assets/img/canvas.png') }}" alt="Sunulyce Logo">
        </div>
    <div class="row mt-5 ">
    <div class="col-md-6">
    <div class="mb-3">
    <h1>Affectation des élèves à la classe {{ $classe->nom }}</h1>
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
    <form action="{{ route('assign.eleves.store', $classe->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="eleve_ids">Sélectionner un  élèves :</label>
            <select name="eleve_ids[]" id="eleve_ids" class="form-control"   style="height: auto; overflow-y: auto;">
                @foreach($eleve as $eleves)
                    <option value="{{ $eleves->id }}">{{ $eleves->prenoms }} {{ $eleves->nom }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Assigner</button>
    </form>
    </div>
       <div class="col-md-6 mt-5">
            <img src="{{ asset('assets/img/classe.jpg') }}" alt="Image description" class="img-fluid ">
        </div>

    </div>
</div>
</body>
</html>
















