<div class="container">
    <h1>Assigner un ou plusieurs professeurs à la classe : {{ $classe->nom }}</h1>

    <form action="{{ route('classes.assign.teachers.store', $classe->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="professeur_ids">Sélectionner un ou plusieurs professeurs :</label>
            <select name="professeur_ids[]" id="professeur_ids" class="form-control" multiple style="height: auto; overflow-y: auto;">
                @foreach($professeurs as $professeur)
                    <option value="{{ $professeur->id }}">{{ $professeur->prenoms }} {{ $professeur->nom }}</option>
                @endforeach
            </select>
        </div>
       
        <button type="submit" class="btn btn-primary">Assigner</button>
    </form>
</div>
