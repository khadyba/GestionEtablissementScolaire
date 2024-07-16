
<div class="container">
    <h1>Tableau de bord Parent</h1>

    @if ($emploiDuTemps)
        <h2>Emploi du temps de {{ $eleve->prenom }} {{ $eleve->nom }}</h2>
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

   
<form action="{{ route('users.logout') }}" method="POST" style="display:inline">

@csrf
<button type="submit" class="btn btn-danger">Déconnexion</button>
</form>
<a href="{{ route('eleves.payInscription') }}" class="btn btn-primary">Payer l'inscription </a>

</div>



















 

      
   

