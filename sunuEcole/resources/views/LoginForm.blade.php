
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connection</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<section id="login">
        <div class="container">
            <div class="row mt-5 ">
                <div class="col-md-6">
                    <div class="mb-3">
                    <h2>Connexion</h2>
                    </div>
                    <form method="POST" action="{{ route('users.login.submit') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Email </label>
                            <input type="email"  name="email" class="form-control" id="email" value="{{ old('email') }}" aria-describedby="emailHelp" required>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Mots De Passe</label>
                            <input id="password" type="password" name="password"  class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary mb-3">Connection</button>
                        <div class="mb-3">
                            <a href="{{ route('users.create') }}">Pas de compte ? Inscrivez-vous !</a>
                        </div>
                </form>               
                </div>
                <div class="col-md-6">
                    <img src="{{ asset('assets/img/login-office.jpeg') }}" alt="Image description" class="img-fluid">
                </div>
            </div>
        </div>
    </section> 
</body>
</html>


  






   <!-- <form method="POST" action="{{ route('users.login.submit') }}">
                        @csrf

                        <div>
                            <label for="email">Email</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
                        </div>

                        <div>
                            <label for="password">Mot de passe</label>
                            <input id="password" type="password" name="password" required>
                        </div>

                        <div>
                            <button type="submit">Se connecter</button>
                        </div>
                        
                        <div>
                            <a href="{{ route('users.store') }}">Pas de compte ? Inscrivez-vous !</a>
                        </div>
                    </form> -->






