<form action="{{ route('users.logout') }}" method="POST" style="display:inline">

@csrf
<button type="submit" class="btn btn-danger">Déconnexion</button>
</form>
@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
<div class="container">
    <h1>Espace Parent</h1>

    <form action="{{ route('parents.eleves.notes') }}" method="GET">
    @csrf
    <input type="text" name="non_de_votre_éléve" placeholder="Nom de famille de  l'élève" required>
   

    <button type="submit" class="btn btn-primary">Afficher les notes</button>
   </form>

<a href="{{ route('parents.parent.payInscription') }}" class="btn btn-primary">Payer l'inscription </a>

</div>



















 

      
   

