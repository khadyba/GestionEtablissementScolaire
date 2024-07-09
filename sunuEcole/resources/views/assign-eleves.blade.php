<!-- resources/views/assign-eleves.blade.php -->




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

    <!-- Afficher les messages de succès -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

   <!-- Formulaire pour affecter des élèves à la classe -->
   <form action="{{ route('assign.eleves.store', $classe->id) }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="eleves">Sélectionner les élèves à affecter</label>
            <select name="eleves[]" id="eleves" class="form-control" multiple>
                @foreach ($eleves as $user)
                    @if ($user->eleves) <!-- Vérifier si la relation eleves existe -->
                        <option value="{{ $user->eleves->id }}">{{ $user->eleves->nom }} {{ $user->eleves->prenoms }}</option>
                    @endif
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Affecter les élèves</button>
    </form>
</div>

