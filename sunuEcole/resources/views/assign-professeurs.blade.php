<div class="container">
    <h1>Assigner un professeur à la classe : {{ $classe->nom }}</h1>

    <form action="{{ route('classes.assign.teachers.store', $classe->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="professeur">Sélectionner un professeur :</label>
            <select name="professeur_id" id="professeur" class="form-control">
                <option value=""></option>
                @foreach($professeurs as $professeur)
                    <option value="{{ $professeur->professeur->id }}">{{ $professeur->professeur->prenoms }} {{ $professeur->professeur->nom }}</option>
                @endforeach
            </select>
        </div>
       
        <button type="submit" class="btn btn-primary">Assigner</button>
    </form>
</div>
