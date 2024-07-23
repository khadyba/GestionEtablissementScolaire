
<div class="container">
    <h1>Liste des Classes</h1>
    <ul>
        @foreach ($classes as $classe)
            <li>
                <a href="{{ route('classes.detail', ['id' => $classe->id]) }}">
                    {{ $classe->nom }}
                </a>
            </li>
        @endforeach
    </ul>
</div>
