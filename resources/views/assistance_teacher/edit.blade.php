@extends('layout')

@section('title')
<title>Editar Asistencia de {{ $assistance_teacher->teacher->lastname . ' ' . $assistance_teacher->teacher->name }}</title>
@endsection

@section('content')
<div class="container">
            <div class="col-lg-12">
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Editar Asistencia de {{ $assistance_teacher->teacher->lastname . ' ' . $assistance_teacher->teacher->name }}</h6>
                </div>
                <div class="card-body">
                  <form action="{{ route('assistance_teacher.update', $assistance_teacher->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                    <div class="form-group row">
                        <div class="col-sm-12">
                          <label for="exampleFormControlInput1" class="form-label"><b>Módulo Formativo</b><font color="red">*</font></label>
                          <select class="form-select" aria-label="Default select example" name="training-module" id="training-module" required>
                            <option value="Profesional/Especialidad" {{ $assistance_teacher->training_module == 'Profesional/Especialidad' ? 'selected' : '' }}>Profesional/Especialidad</option>
                            <option value="Transversal/Empleabilidad"{{ $assistance_teacher->training_module == 'Transversal/Empleabilidad' ? 'selected' : '' }}>Transversal/Empleabilidad</option>
                          </select>
                      </div>
                    </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-group row">
                        <div class="col-sm-6">
                          <label for="exampleFormControlInput1" class="form-label"><b>Período Académico</b><font color="red">*</font></label>
                          <select class="form-select" aria-label="Default select example" name="period" id="period" required>
                            {{--
                            <option value="Segundo" {{ $assistance_teacher->period == 'Segundo' ? 'selected' : '' }}>Segundo</option>
                            <option value="Cuarto" {{ $assistance_teacher->period == 'Cuarto' ? 'selected' : '' }}>Cuarto</option>
                            <option value="Sexto" {{ $assistance_teacher->period == 'Sexto' ? 'selected' : '' }}>Sexto</option>
                            --}}
                            @foreach($periods as $period)
                            <option value="{{ $period->name }}" {{ $assistance_teacher->period == $period->name ? 'selected' : '' }}>{{ $period->name }}</option>
                            @endforeach
                          </select>
                        </div>
                        <div class="col-sm-6">
                          <label for="exampleFormControlInput1" class="form-label"><b>Turno/Sección</b><font color="red">*</font></label>
                          <select class="form-select" aria-label="Default select example" name="turn" id="turn" required>
                            <option value="Diurno" {{ $assistance_teacher->turn == 'Diurno' ? 'selected' : '' }}>Diurno</option>
                            <option value="Nocturno" {{ $assistance_teacher->turn == 'Nocturno' ? 'selected' : '' }}>Nocturno</option>
                          </select>
                      </div>
                      </div>
                    </div>

                    <div class="mb-3">
                      <label for="exampleFormControlInput1" class="form-label"><b>Unidad Didáctica</b><font color="red">*</font></label>
                      <textarea class="form-control" id="validationCustom01" name="didactic-unit" id="didactic-unit" required>{{ $assistance_teacher->didactic_unit }}</textarea>
                    </div>

                    <div class="mb-3">
                        <div class="form-group row">
                        <div class="col-sm-6">
                          <label for="exampleFormControlInput1" class="form-label"><b>Hora de ingreso a clase</b><font color="red">*</font></label>
                          <input type="text" class="form-control timepicker1" name="checkin-time" id="checkin-time" 
                            value="{{ date('Y-m-d H:i', strtotime($assistance_teacher->checkin_time) ) }}"
                          required>
                        </div>
                        <div class="col-sm-6">
                          <label for="exampleFormControlInput1" class="form-label"><b>Hora de salida de clase</b><font color="red">*</font></label>
                          <input type="text" class="form-control timepicker2" name="departure-time" id="departure-time" 
                            value="{{ date('Y-m-d H:i', strtotime($assistance_teacher->departure_time) ) }}" 
                          required>
                        </div>
                        </div>
                    </div>

                    <div class="mb-3">
                      <label for="exampleFormControlInput1" class="form-label"><b>Tema de actividad de aprendizaje</b><font color="red">*</font></label>
                      <input type="text" class="form-control" name="theme" id="theme" value="{{ $assistance_teacher->theme }}" required>
                    </div>

                    <div class="mb-3">
                    <div class="form-group row">
                    <div class="col-sm-6">
                    <label for="exampleFormControlInput1" class="form-label"><b>Lugar de realización de actividad</b><font color="red">*</font></label>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="place" value="Aula" {{ $assistance_teacher->place == 'Aula' ? 'checked' : '' }}>
                        <label class="form-check-label" for="flexRadioDefault1">Aula</label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="place" value="Laboratorio" {{ $assistance_teacher->place == 'Laboratorio' ? 'checked' : '' }}>
                        <label class="form-check-label" for="flexRadioDefault2">Laboratorio</label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="place" value="Taller" {{ $assistance_teacher->place == 'Taller' ? 'checked' : '' }}>
                        <label class="form-check-label" for="flexRadioDefault2">Taller</label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="place" value="" id="another-place">
                        <label class="form-check-label" for="flexRadioDefault2">Otros</label>
                        <input type="text" class="form-control" id="ap" disabled>
                      </div>
                    </div>

                    <div class="col-sm-6">
                    <label for="exampleFormControlInput1" class="form-label"><b>Plataformas educativas de apoyo</b></label>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="educational-platforms[]" value="Moodle Institucional" {{ in_array("Moodle Institucional", $edplat) ? 'checked' : '' }}>
                        <label class="form-check-label" for="flexCheckDefault">Moodle Institucional</label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="educational-platforms[]" value="Google Meet" {{ in_array("Google Meet", $edplat) ? 'checked' : '' }}>
                        <label class="form-check-label" for="flexCheckChecked">Google Meet</label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="educational-platforms[]" value="Skipe" {{ in_array("Skipe", $edplat) ? 'checked' : '' }}>
                        <label class="form-check-label" for="flexCheckChecked">Skipe</label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="educational-platforms[]" id="another-platform" value="">
                        <label class="form-check-label" for="flexCheckChecked">Otros</label>
                        <input type="text" class="form-control" id="apf" disabled>
                      </div>
                    </div>
                    </div>
                    </div>

                    <div class="mb-3">
                      <label for="exampleFormControlInput1" class="form-label"><b>Observaciones</b></label>
                      <textarea class="form-control" id="remarks" name="remarks" >{{ $assistance_teacher->remarks }}</textarea>
                    </div>

                    <div class="mb-3">
                      <button type="submit" class="btn btn-primary">Guardar</button>
                      <a href="{{ route('assistance_teacher') }}" class="btn btn-danger">Cancelar</a>
                    </div>

                  </form>
                </div>
              </div>
            </div>
</div>
@endsection

@section('javascript')

<script>
$( document ).ready(function() {
    
    $('input[name="place"]').change(function(){
        //alert( "otro" );
        if($('#another-place').is(':checked'))
            $('#ap').prop('disabled', false);
        else
            $('#ap').prop('disabled', true);
    });

    $('#ap').change(function() {
        $("#another-place").val($(this).val());
    });


    $('input[name="educational-platforms[]"]').change(function(){
        //alert( "otro" );
        if($('#another-platform').is(':checked'))
            $('#apf').prop('disabled', false);
        else
            $('#apf').prop('disabled', true);
    });

    $('#apf').change(function() {
        $("#another-platform").val($(this).val());
    });

    /*$('.timepicker1').timepicker({
        timeFormat: 'h:mm p',
        interval: 15,
        minTime: '8',
        maxTime: '6:00 pm',
        //defaultTime: '11',
        //startTime: '10:00',
        dynamic: false,
        dropdown: true,
        scrollbar: true
    });*/

    /*$('.timepicker1').datetimepicker({
        language:'es',
        format: "dd/mm/yyyy hh:ii A",
        autoclose: true,
        todayBtn: true,
        startDate: "2013-02-14 10:00",
        minuteStep: 10
    });*/

    /*$('.timepicker2').timepicker({
        timeFormat: 'h:mm p',
        interval: 15,
        minTime: '10',
        maxTime: '8:00 pm',
        //defaultTime: '11',
        //startTime: '10:00',
        dynamic: false,
        dropdown: true,
        scrollbar: true
    });*/

    function generateAllowTimes() {
        var hours = [];
        var start = 5; 
        var end = 23; 

        for (var i = start; i <= end; i++) {
            hours.push(i.toString().padStart(2, '0') + ':00');
            hours.push(i.toString().padStart(2, '0') + ':15');
            hours.push(i.toString().padStart(2, '0') + ':30');
            hours.push(i.toString().padStart(2, '0') + ':45');
        }
        return hours;
    }

    $.datetimepicker.setLocale('es');

    $('.timepicker1').datetimepicker({
        //datepicker:false,
        mask:true,
        allowTimes: generateAllowTimes(),
        timepicker: true,
        format: 'Y-m-d H:i',
        //format: 'Y-m-d h:i A',
        utc: true,
        onShow:function( ct )
        {
         this.setOptions({
            maxDate: $('.timepicker2').val() ? $('.timepicker2').val() : false,
            maxTime: $('.timepicker2').val() ? ( moment( $('.timepicker1').val(),'YYYY-MM-DD HH:mm').format('YYYY-MM-DD') == moment( $('.timepicker2').val(),'YYYY-MM-DD HH:mm').format('YYYY-MM-DD') ? moment($('.timepicker2').val(),'YYYY-MM-DD HH:mm').format('HH:mm') : false ) : false,
            //maxTime: $('.timepicker2').val() ? ( moment( $('.timepicker1').val(),'YYYY-MM-DD hh:mm A').format('YYYY-MM-DD') == moment( $('.timepicker2').val(),'YYYY-MM-DD hh:mm A').format('YYYY-MM-DD') ? moment($('.timepicker2').val(),'YYYY-MM-DD hh:mm A').format('HH:mm') : false ) : false,
         });
          
        },
    });

    $('.timepicker2').datetimepicker({
        //datepicker:false,
        mask:true,
        allowTimes: generateAllowTimes(),
        timepicker: true,
        format: 'Y-m-d H:i',
        //format: 'Y-m-d h:i A',
        utc: true,
        onShow:function( ct )
        {
         this.setOptions({
            minDate: $('.timepicker1').val() ? $('.timepicker1').val() : false,
            minTime: $('.timepicker1').val() ? ( moment($('.timepicker1').val(), 'YYYY-MM-DD HH:mm').format('YYYY-MM-DD') == moment($('.timepicker2').val(), 'YYYY-MM-DD HH:mm').format('YYYY-MM-DD') ? moment($('.timepicker1').val(), 'YYYY-MM-DD HH:mm').format('HH:mm') : false ) : false,
            //minTime: $('.timepicker1').val() ? ( moment($('.timepicker1').val(), 'YYYY-MM-DD hh:mm A').format('YYYY-MM-DD') == moment($('.timepicker2').val(), 'YYYY-MM-DD hh:mm A').format('YYYY-MM-DD') ? moment($('.timepicker1').val(), 'YYYY-MM-DD hh:mm').format('HH:mm') : false ) : false,
         });

        },
        /*onChangeDateTime:function(dp,$input){
          alert( moment($input.val(), 'YYYY-MM-DD hh:mm A').format('YYYY-MM-DD hh:mm A') );
        }*/
    });

    /*
  $('#datepicker').on('change', function() {
    var selectedDate = $(this).val();  // Obtener la fecha y hora seleccionada
    var hour = moment(selectedDate, 'YYYY-MM-DD HH:mm').format('HH:mm');  // Extraer solo la hora
    console.log(hour);  // Muestra solo la hora
});
    */

    //$('.time').mask('00:00');
});


</script>

@endsection