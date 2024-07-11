

@section('content')
    <h1>Modifier la classe</h1>
    <form action="{{ route('classes.update', $classe->id) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom" value="{{ $classe->nom }}" required><br>
        <label for="niveau">Niveau:</label>
        <input type="text" id="niveau" name="niveau" value="{{ $classe->niveau }}" required><br>
        <button type="submit">Mettre à jour</button>
    </form>

