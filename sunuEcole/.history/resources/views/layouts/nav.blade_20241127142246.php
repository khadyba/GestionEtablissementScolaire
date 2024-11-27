<nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Sunu Lycee</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarColor01">
      <ul class="navbar-nav me-auto">

        <li class="nav-item">
          <a class="nav-link active" href="{{ route('home') }}">Acceuil
            <span class="visually-hidden">(current)</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link bg-x" href="{{ route('admin.dashboard') }}">Espace Personnel</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="{{ route('admin.profile.edit') }}">Modifier Mon Profile</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="{{ route('professeurs.list') }}">Liste des professeurs</a>
        </li>
      </ul>
      <form class="d-flex" action="{{ route('admin.logout') }}" method="POST">
         @csrf
        <button class="btn btn-secondary  my-2 my-sm-0" type="submit">Deconnection</button>
      </form>
    </div>
  </div>
</nav>