


    <div class="container">
        <h1>Compléter votre profil</h1>
        
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('professeurs.professeurs.complete-profile.store') }}" method="POST">
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
                <label for="spécialiter">Spécialité</label>
                <input type="text" name="spécialiter" id="spécialiter" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="adresse">Adresse</label>
                <input type="text" name="adresse" id="adresse" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="telephone">Téléphone</label>
                <input type="text" name="telephone" id="telephone" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Compléter le profil</button>
        </form>
    </div>

