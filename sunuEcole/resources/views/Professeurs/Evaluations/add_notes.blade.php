<div class="container">
    <h1>Ajouter des Notes pour l'Évaluation {{ $evaluation->titre }} dans la Classe {{ $classe->nom }}</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('professeurs.evaluations.store_notes', $classe->id) }}" method="POST">
        @csrf

        @foreach ($eleves as $eleve)
            <h3>{{ $eleve->prenoms }} {{ $eleve->nom }}</h3>

            <div class="form-group">
                <label for="notes[{{ $eleve->id }}][valeur]">Note pour {{ $evaluation->titre }} ({{ $evaluation->type }}):</label>
                <input type="number" name="notes[{{ $eleve->id }}][valeur]" class="form-control" id="notes[{{ $eleve->id }}][valeur]" required>

                <label for="notes[{{ $eleve->id }}][coefficient]">Coefficient:</label>
                <input type="number" name="notes[{{ $eleve->id }}][coefficient]" class="form-control" id="notes[{{ $eleve->id }}][coefficient]" required>

                <!-- Hidden inputs pour evaluation_id et eleve_id -->
                <input type="hidden" name="notes[{{ $eleve->id }}][evaluation_id]" value="{{ $evaluation->id }}">
                <input type="hidden" name="notes[{{ $eleve->id }}][eleve_id]" value="{{ $eleve->id }}">

                <div class="form-group">
                    <label for="notes[{{ $eleve->id }}][appreciations]">Appréciations:</label>
                    <textarea name="notes[{{ $eleve->id }}][appreciations]" class="form-control" id="notes[{{ $eleve->id }}][appreciations]"></textarea>
                </div>
            </div>
        @endforeach

        <button type="submit" class="btn btn-primary">Enregistrer les notes</button>
    </form>
</div>
