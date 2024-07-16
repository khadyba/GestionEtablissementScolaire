
<div class="container">
        <h1>Détails du Cours</h1>
        <p><strong>Titre :</strong> {{ $cours->titre }}</p>
        <p><strong>Description :</strong> {{ $cours->descriptions }}</p>
        <p><strong>Jour :</strong> {{ $cours->jours }}</p>
        <p><strong>Heure de début :</strong> {{ $cours->heure_debut }}</p>
        <p><strong>Heure de fin :</strong> {{ $cours->heure_fin }}</p>
        <p><strong>Professeur :</strong> {{ $cours->professeur->prenoms}}  {{ $cours->professeur->nom}}</p>
        <p><strong>Salle de classe :</strong> 
        @if ($cours->salleDeClasse)
            {{ $cours->salleDeClasse->numéro }}
        @else
            Aucune salle de classe attribuée
        @endif
        </p>
        <p><strong>Fichier du cours :</strong> <a href="{{ Storage::url($cours->fichier_cours) }}" target="_blank">Télécharger le cours</a></p>
    </div>
    <a href="{{ route('eleves.cours.index') }}">Retour à la liste des cours</a>
</div>

