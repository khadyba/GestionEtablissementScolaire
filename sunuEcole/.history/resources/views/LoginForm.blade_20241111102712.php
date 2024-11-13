<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/canvas.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
<section id="login">
    <div class="container">
        <div class="mt-3 mb-4">
            <img src="{{ asset('assets/img/canvas.png') }}" alt="Sunulyce Logo">
        </div>
        <div class="row mt-5">
            <div class="col-md-6">
                <div class="mb-3">
                    <h2>Connexion</h2>
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
                <form method="POST" action="{{ route('users.login.submit') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" id="email" value="{{ old('email') }}" aria-describedby="emailHelp" required>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Mot de passe</label>
                        <input id="password" type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary mb-3">Connexion</button>
                    <div class="mb-3">
                        <a href="{{ route('users.create') }}">Pas de compte ? Inscrivez-vous !</a>
                    </div>
                </form>
                @if ($errors->has('credentials'))
                    <div class="alert alert-danger">
                        {{ $errors->first('credentials') }}
                    </div>
                @endif
            </div>
            <div class="col-md-6">
                <img src="{{ asset('assets/img/login-office.jpeg') }}" alt="Image description" class="img-fluid">
            </div>
        </div>
    </div>
</section>
</body>
</html>
