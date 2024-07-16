
<div class="container">
    <h1>Ajouter des Notes pour la Classe {{ $classe->nom }}</h1>

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

            @foreach ($evaluations as $evaluation)
                <div class="form-group">
                    <label for="notes[{{ $eleve->id }}][{{ $evaluation->id }}][valeur]">Note pour {{ $evaluation->titre }} ({{ $evaluation->type }}):</label>
                    <input type="number" name="notes[{{ $loop->parent->index }}][valeur]" class="form-control" id="notes[{{ $eleve->id }}][{{ $evaluation->id }}][valeur]" required>

                    <input type="hidden" name="notes[{{ $loop->parent->index }}][evaluation_id]" value="{{ $evaluation->id }}">
                    <input type="hidden" name="notes[{{ $loop->parent->index }}][eleve_id]" value="{{ $eleve->id }}">
                </div>
                <div class="form-group">
                    <label for="notes[{{ $eleve->id }}][{{ $evaluation->id }}][appreciations]">Appréciations:</label>
                    <textarea name="notes[{{ $loop->parent->index }}][appreciations]" class="form-control" id="notes[{{ $eleve->id }}][{{ $evaluation->id }}][appreciations]"></textarea>
                </div>
            @endforeach
        @endforeach

        <button type="submit" class="btn btn-primary">Enregistrer les notes</button>
    </form>
</div>

