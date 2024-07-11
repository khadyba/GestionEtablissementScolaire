


<div class="container">
    <h1>Compléter votre profil</h1>
    <form action="{{ route('parents.completeProfile') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nom">Nom</label>
            <input type="text" name="nom" id="nom" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="prenoms">Prénoms</label>
            <input type="text" name="prenoms" id="prenoms" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="non_de_votre_éléve">Nom De Votre Eléve</label>
            <input type="text" name="non_de_votre_éléve" id="non_de_votre_éléve" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="telephone">telephone</label>
            <input type="number" name="telephone" id="telephone" class="form-control" required>
        </div>
      
        <button type="submit" class="btn btn-primary">Completer</button>
    </form>
    <div class="container">
    <a href="{{ route('eleves.payInscription') }}" class="btn btn-primary">Payer mon inscription</a>
</div>
</div>

