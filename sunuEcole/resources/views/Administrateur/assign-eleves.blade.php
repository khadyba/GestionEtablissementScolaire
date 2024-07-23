<div class="container">
    <h1>Affectation des élèves à la classe {{ $classe->nom }}</h1>

    <!-- Afficher les erreurs de validation -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    {{-- @dd($eleves) --}}
    <form action="{{ route('assign.eleves.store', $classe->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="eleve_ids">Sélectionner un ou plusieurs élèves :</label>
            <select name="eleve_ids[]" id="eleve_ids" class="form-control"   style="height: auto; overflow-y: auto;">
                @foreach($eleves as $eleve)
                    <option value="{{ $eleve->id }}">{{ $eleve->prenoms }} {{ $eleve->nom }}</option>
                @endforeach
            </select>
         
        </div>
        <button type="submit" class="btn btn-primary">Assigner</button>
    </form>
</div>
