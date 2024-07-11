
<div class="container">


@if ($cours)
    <h1>Détails du Cours</h1>

    <div>
        <p><strong>Titre :</strong> {{ $cours->titre }}</p>
        <p><strong>Description :</strong> {{ $cours->descriptions }}</p>
        <p><strong>Jour :</strong> {{ $cours->jours }}</p>
        <p><strong>Heure de début :</strong> {{ $cours->heure_debut }}</p>
        <p><strong>Heure de fin :</strong> {{ $cours->heure_fin }}</p>
        <p><strong>Professeur :</strong> {{ $cours->professeur->nom_complet }}</p>
        <p><strong>Fichier du cours :</strong> <a href="{{ Storage::url($cours->fichier_cours) }}" target="_blank">Télécharger le cours</a></p>
    </div>
@else
    <p>Le cours demandé n'existe pas ou a été supprimé.</p>
@endif
<td><a href="{{ route('professeurs.cours.list.prof') }}">Retour a la liste</a></td>

</div>

