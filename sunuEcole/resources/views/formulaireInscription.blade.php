

<!DOCTYPE html>
<html>
<head>
    <title>Inscription</title>
</head>
<body>
    <h1>Formulaire d'inscription</h1>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div>
            {{ session('success') }}
        </div>
    @endif
    <form action="{{ route('users.store') }}" method="POST">
    @csrf

    <label for="email">Email :</label>
    <input type="email" id="email" name="email" required><br>

    <label for="password">Mot de passe :</label>
    <input type="password" id="password" name="password" required><br>

    <label for="typecompte">Type de compte :</label>
    <select id="typecompte" name="typecompte" required>
        <option value="professeurs">Professeur</option>
        <option value="eleves">Élève</option>
        <option value="parents">Parent</option>
    </select><br>

    <label for="etablissement_id">Établissement :</label>
    <select id="etablissement_id" name="etablissement_id" required>
        @foreach($etablissements as $etablissement)
             <option value=""></option>
            <option value="{{ $etablissement->id }}">{{ $etablissement->nom }}</option>
        @endforeach
    </select><br>

    <button type="submit">S'inscrire</button>
</form>

</body>
</html>
