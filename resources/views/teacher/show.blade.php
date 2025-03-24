@extends('layout')

@section('title')
<title>Registro de asistencias de {{ $teacher->name . ' ' . $teacher->lastname }}</title>
@endsection

@section('content')
<div class="container-fluid">
            <div class="col-lg-12">
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold">Registro de asistencias de {{ $teacher->name . ' ' . $teacher->lastname }}</h6>
                </div>
                <div class="card-body">
                    {{-- $assistances->links() --}}
                  <div class="table-responsive">
                                <table class="table table-hover" id="datat">
                                    <thead>
                                        <tr class="table-secondary">
                                            <th>Fecha de subida</th>
                                            <th>Módulo Formativo</th>
                                            <th>Período Académico</th>
                                            <th>Turno/Sección</th>
                                            <th>Unidad Didáctica</th>
                                            <th>Hora de ingreso</th>
                                            <th>Hora de salida</th>
                                            <th>Tema de actividad de aprendizaje</th>
                                            <th>Lugar de realización de actividad</th>
                                            <th>Plataformas educativas de apoyo</th>
                                            <th>Observaciones</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr class="table-secondary">
                                            <th>Fecha de subida</th>
                                            <th>Módulo Formativo</th>
                                            <th>Período Académico</th>
                                            <th>Turno/Sección</th>
                                            <th>Unidad Didáctica</th>
                                            <th>Hora de ingreso</th>
                                            <th>Hora de salida</th>
                                            <th>Tema de actividad de aprendizaje</th>
                                            <th>Lugar de realización de actividad</th>
                                            <th>Plataformas educativas de apoyo</th>
                                            <th>Observaciones</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        {{--
                                        @foreach($assistances as $assistance_teacher)
                                        <tr>
                                            <td><small>{{ date('Y/m/d h:i A', strtotime($assistance_teacher->created_at)) }}</small></td>
                                            <td><small>{{ $assistance_teacher->training_module }}</small></td>
                                            <td><small>{{ $assistance_teacher->period }}</small></td>
                                            <td><small>{{ $assistance_teacher->turn }}</small></td>
                                            <td><small>{{ $assistance_teacher->didactic_unit }}</small></td>
                                            <td><small>{{ date('h:i A', strtotime($assistance_teacher->checkin_time)) }}</small></td>
                                            <td><small>{{ date('h:i A', strtotime($assistance_teacher->departure_time)) }}</small></td>
                                            <td><small>{{ $assistance_teacher->theme }}</small></td>
                                            <td><small>{{ $assistance_teacher->place }}</small></td>
                                            <td><small>{{ $assistance_teacher->educational_platforms }}</small></td>
                                            <td><small>{{ $assistance_teacher->remarks }}</small></td>
                                        </tr>
                                        @endforeach
                                        --}}
                                    </tbody>
                                </table>
                            </div>
                            {{-- $assistances->links() --}}
                </div>
              </div>
            </div>
</div>
@endsection

@section('javascript')
<script>
$( document ).ready(function() {

    /*$('#datat').DataTable({
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json'
        },
    });*/

    $('#datat').DataTable({
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json'
        },
        processing: true,
        serverSide: true,
        ajax:"{{ route('teacher.show', $teacher->id) }}",
        columns: [
            {data:'created_at', name:'created_at'},
            {data:'training_module', name:'training_module'},
            {data:'period', name:'period'},
            {data:'turn', name:'turn'},
            {data:'didactic_unit', name:'didactic_unit'},
            {data:'checkin_time', name:'checkin_time'},
            {data:'departure_time', name:'departure_time'},
            {data:'theme', name:'theme'},
            {data:'place', name:'place'},
            {data:'educational_platforms', name:'educational_platforms'},
            {data:'remarks', name:'remarks'},
        ]
    });

});
</script>
@endsection