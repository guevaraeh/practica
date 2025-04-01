{{-- @can('manage-assistance') @endcan --}}

        <nav class="navbar navbar-expand navbar-light bg-black topbar mb-4 static-top shadow">
          <div class="container">
            <div id="navbar" class="navbar-collapse collapse">
              <ul class="nav navbar-nav">
                <!--<li class="nav-item">
                  <a class="nav-link active" aria-current="page" href="#">Active</a>
                </li>-->
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('teacher') }}">Lista de profesores</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('teacher.create') }}">Crear profesor</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('assistance_teacher') }}">Lista de asistencias</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('assistance_teacher.create') }}">Crear asistencia</a>
                </li>
                <!--<li class="nav-item">
                  <a class="nav-link disabled" aria-disabled="true">Disabled</a>
                </li>-->
              </ul>
            </div>
          </div>
        </nav>
