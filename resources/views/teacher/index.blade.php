@extends('layout')

@section('title')
<title>Lista de profesores</title>
@endsection

@section('content')
<div class="container">
            <div class="col-lg-12">
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold">Lista de profesores</h6>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                                <table class="table table-hover" id="datat">
                                    <thead>
                                        <tr class="table-secondary">
                                            <th>#</th>
                                            <th>Apellidos</th>
                                            <th>Nombres</th>
                                            <th>Nro. de registros de asistencia</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    	@foreach($teachers as $teacher)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $teacher->lastname }}</td>
                                            <td>{{ $teacher->name }}</td>
                                            <td>{{ $teacher->assistances->count() }}</td>
                                            <td><a href="{{ route('teacher.show', $teacher->id) }}">Asistencias</a></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                </div>
              </div>
            </div>
</div>
@endsection

@section('javascript')
<script>
$( document ).ready(function() {

    $('#datat').DataTable({
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json'
        }
    });

});
</script>
@endsection