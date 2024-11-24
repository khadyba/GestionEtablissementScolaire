<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Completer profile</title>
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
        <h1>Compléter votre profil</h1>
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
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <form action="{{ route('professeurs.complete-profile.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="nom">Nom</label>
                <input type="text" name="nom" id="nom" class="form-control"  placeholder=" Exemple : Doh" required>
            </div>
            <div class="mb-3">
                <label for="prenoms">Prénoms</label>
                <input type="text" name="prenoms" id="prenoms" class="form-control" placeholder=" Exemple : Joe" required>
            </div>
            <div class="mb-3">
                <label for="spécialiter">Spécialité</label>
                <input type="text" name="spécialiter" id="spécialiter" class="form-control" placeholder=" Exemple : Français" required>
            </div>
            <div class="mb-3">
                <label for="adresse">Adresse</label>
                <input type="text" name="adresse" id="adresse" class="form-control"  placeholder=" Exemple : " required>
            </div>
            <div class="mb-3">
                <label for="telephone">Téléphone</label>
                <input type="text" name="telephone" id="telephone" class="form-control"  placeholder=" Exemple : 77 000 00 00 "  required>
            </div>
            <button type="submit" class="btn btn-primary">Compléter le profil</button>
        </form>
     </div>
     <div class="col-md-6 mt-5">
            <img src="{{ asset('assets/img/personnes.png') }}" alt="Image description" class="img-fluid">
     </div>
   </div>
</div>
</body>
</html>






