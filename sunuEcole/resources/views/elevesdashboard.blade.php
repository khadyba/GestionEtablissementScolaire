


<div class="container">
    <h1>Compléter votre profil</h1>
    <form action="{{ route('eleves.completeProfile') }}" method="POST">
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
            <label for="adresse">Adresse</label>
            <input type="text" name="adresse" id="adresse" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="non_de_votre_tuteur">Nom de Votre Tuteur ou Tutrice</label>
            <input type="text" name="non_de_votre_tuteur" id="non_de_votre_tuteur" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="email_tuteur">email de votre Tuteur ou Tutrice</label>
            <input type="email_tuteur" name="email_tuteur" id="email_tuteur" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="dateDeNaissance">Date de Naissance</label>
            <input type="date" name="dateDeNaissance" id="dateDeNaissance" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="classe_id">Classe (facultatif)</label>
            <select name="classe_id" id="classe_id" class="form-control">
                <option value="">-- Sélectionner une classe --</option>
                @foreach($classes as $classe)
                    <option value="{{ $classe->id }}">{{ $classe->nom }}</option>
                @endforeach
            </select>
        </div>
        <div>
        <label for="parent_id">Parent:</label>
        <select id="parent_id" name="parent_id">
            <option value="">Sélectionnez un parent</option>
            @foreach($parents as $parent)
                <option value="{{ $parent->id }}" @if($eleve->parent_id == $parent->id) selected @endif>{{ $parent->nom }} {{ $parent->prenoms }}</option>
            @endforeach
        </select>
    </div>
        <button type="submit" class="btn btn-primary">Completer</button>
    </form>
    <form action="{{ route('users.logout') }}" method="POST" style="display:inline">
    @csrf
    <button type="submit" class="btn btn-danger">Déconnexion</button>
</form>
    <div class="container">
    <a href="{{ route('eleves.payInscription') }}" class="btn btn-primary">Payer mon inscription</a>
</div>
</div>

