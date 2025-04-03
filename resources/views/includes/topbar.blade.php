{{-- @can('manage-assistance') @endcan --}}

<nav class="navbar navbar-expand-lg bg-body-tertiary mb-4 topbar" data-bs-theme="dark">
  <div class="container">
    <span class="navbar-brand mb-0 h1">Asistencias</span>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Profesores
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route('teacher') }}">Lista</a></li>
            <li><a class="dropdown-item" href="{{ route('teacher.create') }}">Crear profesor</a></li>
          </ul>
        </li>
        
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Assistencias
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route('assistance_teacher') }}">Lista</a></li>
            <li><a class="dropdown-item" href="{{ route('assistance_teacher.create') }}">Crear asistencia</a></li>
          </ul>
        </li>

      </ul>
    </div>
  </div>
</nav>