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


<div class= "container ">

        <h1 class="text-center align-items-center">Modifier Votre mots de passe </h1>

        <div class="row   d-flex align-items-center justify-content-center vh-100">

            <div class="col-md-6">
                @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
               @endif
                <form action="{{ route('professeurs.update.password') }}" method="POST">
                    @csrf
                    @method('PUT')

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="form-group mb-3">
                        <label for="current_password">Mot de passe actuel</label>
                        <input type="password" name="current_password" id="current_password" class="form-control" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="new_password">Nouveau mot de passe</label>
                        <input type="password" name="new_password" id="new_password" class="form-control" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="new_password_confirmation">Confirmer le nouveau mot de passe</label>
                        <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Modifier mon mot de passe</button>
                </form>
            </div>


            <div class="col-md-6 text-center">
            <img src="{{ asset('assets/img/deposi.jpg') }}" alt="Image description" class="img-fluid ">
            </div>


        </div>
</div>


</body>
</html>