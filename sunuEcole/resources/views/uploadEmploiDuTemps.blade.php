


    <h1>Importer  un fichiers d'emplois du temps</h1>
    @if (session('success'))
        <div>{{ session('success') }}</div>
    @endif
    <form action="{{ route('emplois_du_temps.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="schedule_file">Fichier d'emploi du temps:</label>
            <input type="file" id="schedule_file" name="schedule_file" required>
        </div>
        <button type="submit">Telecharger</button>
    </form>

