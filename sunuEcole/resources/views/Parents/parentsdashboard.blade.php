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

    @if ($emploiDuTemps)
        <h2>Emploi du temps de {{ $eleve->prenoms }} {{ $eleve->nom }}</h2>
        <ul>
            @foreach ($emploiDuTemps as $emploi)
                <li>
                    <a href="{{ route('emplois_du_temps.download', ['id' => $emploi->id]) }}">
                        {{ $emploi->nom_original }}
                    </a>
                </li>
            @endforeach
        </ul>
    @else
        <p>Aucun emploi du temps disponible pour cet élève.</p>
    @endif

   

    <form action="{{ route('parents.eleves.notes') }}" method="GET">
    @csrf
    <input type="text" name="non_de_votre_éléve" placeholder="Nom de famille de  l'élève" required>
   

    <button type="submit" class="btn btn-primary">Afficher les notes</button>
   </form>

<a href="{{ route('parents.parent.payInscription') }}" class="btn btn-primary">Payer l'inscription </a>

</div>



















 

      
   
