<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('title')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
    <style type="text/css">
      nav .navbar-nav li a{
      color: white !important;
      }
    </style>
  </head>
  <body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script type="text/javascript" src="{{ asset('/jquery/jquery-3.7.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/moment/moment.min.js') }}"></script>

    <!--<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/fontawesome.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/js/fontawesome.min.js"></script>-->

    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
    
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>
    
    {{--
    <link rel="stylesheet" href="{{ asset('/bootstrap4-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" />
    <script type="text/javascript" src="{{ asset('/bootstrap4-datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
    --}}

    <link rel="stylesheet" href="{{ asset('/jquerydatetimepicker/jquery.datetimepicker.min.css') }}" />
    <script type="text/javascript" src="{{ asset('/jquerydatetimepicker/jquery.datetimepicker.full.min.js') }}"></script>
    

    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">

        <!-- Barra de arriba -->
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

        @if (Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>¡Exito!</strong> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <i class="fa fa-times"></i>
                </button>
            </div>
        @endif

        @if (Session::has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>¡Error!</strong> {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <i class="fa fa-times"></i>
                </button>
            </div>
        @endif

        <!-- Contenido de la pagina -->
          @yield('content')



      </div>
    </div>
    @yield('javascript')
  </body>
</html>