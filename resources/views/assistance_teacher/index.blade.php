@extends('layout')

@section('title')
<title>Lista de Asistencias</title>
@endsection

@section('content')

<form method="POST" id="deleteall">
    @csrf
    @method('DELETE')
</form>

<div class="container-fluid">
            <div class="col-lg-12">
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Asistencias</h6>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                                <table class="table table-hover" id="datat">
                                    <thead>
                                        <tr>
                                            <th>Buscar</th>
                                            <th>Buscar</th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            {{--<th></th>--}}
                                            <th>Buscar</th>
                                            <th>Buscar</th>
                                            {{--<th></th>--}}
                                            <th>Buscar</th>
                                            <th>Buscar</th>
                                            {{--<th>Buscar</th>--}}
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <thead class="table-light">
                                        <tr>
                                            <th>Fecha de subida</th>
                                            <th>Apellidos y Nombres</th>
                                            <th>Módulo Formativo</th>
                                            <th>Período Académico</th>
                                            <th>Turno/Sección</th>
                                            {{--<th>Unidad Didáctica</th>--}}
                                            <th>Hora de ingreso</th>
                                            <th>Hora de salida</th>
                                            {{--<th>Tema de actividad de aprendizaje</th>--}}
                                            <th>Lugar</th>
                                            <th>Plataformas de apoyo</th>
                                            {{--<th>Observaciones</th>--}}
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tfoot class="table-light">
                                        <tr>
                                        	<th>Fecha de subida</th>
                                            <th>Apellidos y Nombres</th>
                                            <th>Módulo Formativo</th>
                                            <th>Período Académico</th>
                                            <th>Turno/Sección</th>
                                            {{--<th>Unidad Didáctica</th>--}}
                                            <th>Hora de ingreso</th>
                                            <th>Hora de salida</th>
                                            {{--<th>Tema de actividad de aprendizaje</th>--}}
                                            <th>Lugar</th>
                                            <th>Plataformas de apoyo</th>
                                            {{--<th>Observaciones</th>--}}
                                            <th>Acciones</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>

                            {{--
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                              Launch demo modal
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                    ...
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary">Save changes</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                            --}}
                </div>
              </div>
            </div>
</div>
@endsection

@section('javascript')
<script>
$( document ).ready(function() {

    var dt = $('#datat').DataTable({
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json'
        },
        pageLength: 25,
        processing: true,
        serverSide: true,
        ajax:"{{ route('assistance_teacher') }}",
        columns: [
            {data:'created_at', name:'created_at'},
            {data:'teacher_name', name:'teacher_name'},
            {data:'training_module', name:'training_module'},
            {data:'period', name:'period'},
            {data:'turn', name:'turn'},
            //{data:'didactic_unit', name:'didactic_unit'},
            {data:'checkin_time', name:'checkin_time'},
            {data:'departure_time', name:'departure_time'},
            //{data:'theme', name:'theme'},
            {data:'place', name:'place'},
            {data:'educational_platforms', name:'educational_platforms'},
            //{data:'remarks', name:'remarks'},
            {data:'action', name:'action'},
        ],
        initComplete: function () {
            this.api()
                .columns([0,1,5,6,7,8])
                .every(function () {
                    let column = this;
                    let title = column.header().textContent;
     
                    // Create input element
                    let input = document.createElement('input');
                    input.placeholder = title;
                    //input.setAttribute('class', 'form-control datepickersearch');
                    input.setAttribute('class', 'form-control');
                    //column.footer().replaceChildren(input);
                    column.header().replaceChildren(input);
     
                    // Event listener for user input
                    input.addEventListener('keyup', () => {
                        if (column.search() !== this.value) {
                            column.search(input.value).draw();
                        }
                    });
                });

            /*this.api()
                .columns([2,3,4])
                .every(function () {
                    let column = this;
     
                    // Create select element
                    let select = document.createElement('select');
                    select.setAttribute('class', 'form-select');
                    select.add(new Option(''));
                    column.footer().replaceChildren(select);
                    
                    // Add list of options
                    column
                        .data()
                        .unique()
                        .sort()
                        .each(function (d, j) {
                            select.add(new Option(d));
                        });

                    // Apply listener for user change in value
                    select.addEventListener('change', function () {
                        column
                            .search(select.value, {exact: true})
                            .draw();
                    });
                });*/

            this.api()
                .columns([2])
                .every(function () {
                    let column = this;
     
                    // Create select element
                    let select = document.createElement('select');
                    select.setAttribute('class', 'form-select');
                    select.add(new Option(''));
                    //column.footer().replaceChildren(select);
                    column.header().replaceChildren(select);
                    
                    // Add list of options
                    select.add(new Option('Profesional/Especialidad'));
                    select.add(new Option('Transversal/Empleabilidad'));

                    // Apply listener for user change in value
                    select.addEventListener('change', function () {
                        column
                            .search(select.value, {exact: true})
                            .draw();
                    });
                });

            this.api()
                .columns([3])
                .every(function () {
                    let column = this;
     
                    // Create select element
                    let select = document.createElement('select');
                    select.setAttribute('class', 'form-select');
                    select.add(new Option(''));
                    //column.footer().replaceChildren(select);
                    column.header().replaceChildren(select);
                    
                    // Add list of options
                    @foreach ($periods as $period)
                    select.add(new Option('{{ $period->name }}'));
                    @endforeach

                    // Apply listener for user change in value
                    select.addEventListener('change', function () {
                        column
                            .search(select.value, {exact: true})
                            .draw();
                    });
                });

            this.api()
                .columns([4])
                .every(function () {
                    let column = this;
     
                    // Create select element
                    let select = document.createElement('select');
                    select.setAttribute('class', 'form-select');
                    select.add(new Option(''));
                    //column.footer().replaceChildren(select);
                    column.header().replaceChildren(select);
                    
                    // Add list of options
                    select.add(new Option('Diurno'));
                    select.add(new Option('Nocturno'));

                    // Apply listener for user change in value
                    select.addEventListener('change', function () {
                        column
                            .search(select.value, {exact: true})
                            .draw();
                    });
                });

        }

    });

    dt.on('draw', function() {
        $('.swalDefaultSuccess').click(function(){
            Swal.fire({
                title: '¿Esta seguro que desea eliminarlo?',
                text: 'Registro de asistencia del '+$(this).val(),
                showDenyButton: true,
                //showCancelButton: true,
                confirmButtonText: "Si, eliminarlo",
                denyButtonText: "No, cancelar",
                icon: "warning",
            }).then((result) => {
                if(result.isConfirmed){
                    $('#deleteall').attr('action', $(this).attr('formaction'));
                    $('#deleteall').submit();
                }
            })
        });

    });
    

    /*$('.swalDefaultSuccess').click(function(){
        Swal.fire({
            title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: "Save",
            denyButtonText: `Don't save`
        })
    });*/

    @if(Session::has('success'))
    toastr.success('<strong>¡Exito!</strong><br>'+'{{ session("success") }}');
    @endif

});
</script>
@endsection