@if(session('identifiants'))
    <div class="alert alert-success">
        <p>Utilisateur créé avec succès.</p>
        <p>Email : {{ session('identifiants')['email'] }}</p>
        <p>Mot de passe : {{ session('identifiants')['password'] }}</p>
    </div>
    <div>
 <a href="{{ route('classes.index') }}" class="btn btn-primary">Retour à la liste des classes</a>
    </div>
@endif
