<?php

namespace App\Http\Controllers;

use App\Models\AssistanceTeacher;
use App\Models\Period;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAssistanceTeacherRequest;
use App\Http\Requests\UpdateAssistanceTeacherRequest;
use DataTables;

class AssistanceTeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //$assistance_teachers = AssistanceTeacher::get();
        //return view('assistance_teacher.index',['assistance_teachers' => $assistance_teachers]);
        /*return view('assistance_teacher.index', [
            'assistance_teachers' => AssistanceTeacher::orderBy('id', 'desc')->paginate(10)
        ]);*/
        //SELECT DATE_FORMAT(checkin_time, "%Y/%m/%d %h:%i %r") FROM assistance_teachers WHERE 1
        if($request->ajax())
        {
            $assistance_teachers = AssistanceTeacher::query()
                ->select([DB::raw("CONCAT(teachers.lastname,' ',teachers.name) as teacher_name"),'assistance_teachers.*'])
                ->join('teachers', 'assistance_teachers.teacher_id', '=', 'teachers.id')
                ->orderBy('assistance_teachers.id', 'desc');
            return DataTables::eloquent($assistance_teachers)
                                /*->addColumn('teacher_name',function (AssistanceTeacher $data){
                                    return $data->teacher->lastname .' '. $data->teacher->name;
                                })*/
                                ->filterColumn('teacher_name', function($query, $keyword) {
                                    $sql = "CONCAT(teachers.lastname,' ',teachers.name) like ?";
                                    $query->whereRaw($sql, ["%{$keyword}%"]);
                                })
                                ->editColumn('created_at', function(AssistanceTeacher $data) {
                                    return date('Y/m/d h:i A', strtotime($data->created_at));
                                })
                                ->editColumn('checkin_time', function(AssistanceTeacher $data) {
                                    return date('Y-m-d h:i A', strtotime($data->checkin_time));
                                })
                                ->editColumn('departure_time', function(AssistanceTeacher $data) {
                                    return date('Y-m-d h:i A', strtotime($data->departure_time));
                                })
                                ->filterColumn('checkin_time', function($query, $keyword) {
                                    $sql = "DATE_FORMAT(created_at, '%Y/%m/%d %h:%i %r') like ?";
                                    $query->whereRaw($sql, ["%{$keyword}%"]);
                                })
                                ->filterColumn('checkin_time', function($query, $keyword) {
                                    $sql = "DATE_FORMAT(checkin_time, '%Y/%m/%d %h:%i %r') like ?";
                                    $query->whereRaw($sql, ["%{$keyword}%"]);
                                })
                                ->filterColumn('departure_time', function($query, $keyword) {
                                    $sql = "DATE_FORMAT(departure_time, '%Y/%m/%d %h:%i %r') like ?";
                                    $query->whereRaw($sql, ["%{$keyword}%"]);
                                })
                                ->addColumn('action',function (AssistanceTeacher $data){
                                    $updated = '';
                                    if(strtotime($data->created_at) < strtotime($data->updated_at))
                                    {
                                        $updated = '<tr>
                                                                <td><b><small>Editado</small></b></td>
                                                                <td><b><small>'.date('Y-m-d h:i A', strtotime($data->updated_at)).'</small><b></td>
                                                            </tr>';
                                    }
                                    $links = 
                                      '<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal'.$data->id.'" title="Ver registro completo">
                                          <i class="bi-eye"></i>
                                        </button>

                                        <div class="modal fade" id="modal'.$data->id.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                          <div class="modal-dialog modal-lg modal-dialog-centered">
                                            <div class="modal-content">
                                              <div class="modal-header bg-primary">
                                                <h5 class="modal-title text-light" id="exampleModalLabel"> Registro de '.date('Y-m-d h:i A', strtotime($data->created_at)).'</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                              </div>
                                              <div class="modal-body">

                                                <div class="table-responsive">
                                                    <table class="table table-hover table-bordered">
                                                        <tbody>
                                                            <tr>
                                                                <td><b><small>Apellidos y Nombres</small></b></td>
                                                                <td><small>'.$data->teacher->lastname.' '.$data->teacher->name.'</small></td>
                                                            </tr>
                                                            <tr>
                                                                <td><b><small>Módulo Formativo</small></b></td>
                                                                <td><small>'.$data->training_module.'</small></td>
                                                            </tr>
                                                            <tr>
                                                                <td><b><small>Período Académico</small></b></td>
                                                                <td><small>'.$data->period.'</small></td>
                                                            </tr>
                                                            <tr>
                                                                <td><b><small>Turno/Sección</small></b></td>
                                                                <td><small>'.$data->turn.'</small></td>
                                                            </tr>
                                                            <tr>
                                                                <td><b><small>Unidad Didáctica</small></b></td>
                                                                <td><small>'.$data->didactic_unit.'</small></td>
                                                            </tr>
                                                            <tr>
                                                                <td><b><small>Hora de ingreso</small></b></td>
                                                                <td><small>'.date('Y-m-d h:i A', strtotime($data->checkin_time)).'</small></td>
                                                            </tr>
                                                            <tr>
                                                                <td><b><small>Hora de salida</small></b></td>
                                                                <td><small>'.date('Y-m-d h:i A', strtotime($data->departure_time)).'</small></td>
                                                            </tr>
                                                            <tr>
                                                                <td><b><small>Tema de actividad de aprensizaje</small></b></td>
                                                                <td><small>'.$data->theme.'</small></td>
                                                            </tr>
                                                            <tr>
                                                                <td><b><small>Lugar de realización de actividad</small></b></td>
                                                                <td><small>'.$data->place.'</small></td>
                                                            </tr>
                                                            <tr>
                                                                <td><b><small>Plataformas educativas de apoyo</small></b></td>
                                                                <td><small>'.$data->educational_platforms.'</small></td>
                                                            </tr>
                                                            <tr>
                                                                <td><b><small>Observaciones</small></b></td>
                                                                <td><small>'.$data->remarks.'</small></td>
                                                            </tr>
                                                            '.$updated.'
                                                        </tbody>
                                                    </table>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                    '.
                                    '<a href="'.route('assistance_teacher.edit',$data->id).'" class="btn btn-info" title="Editar"><i class="bi-pencil"></i></a>'
                                    .
                                    '<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modaldelete'.$data->id.'" title="Eliminar">
                                      <i class="bi-trash"></i>
                                    </button>

                                    <div class="modal fade" id="modaldelete'.$data->id.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                      <div class="modal-dialog modal-sm modal-dialog-centered">
                                        <div class="modal-content">
                                          <div class="modal-header bg-danger">
                                            <h5 class="modal-title text-light" id="exampleModalLabel">¿Seguro que quieres eliminar el registro de asistencia de '.$data->teacher->lastname.' '.$data->teacher->name.' del '.date('Y-m-d h:i A', strtotime($data->created_at)).'?</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                          </div>
                                          <div class="modal-footer">
                                            <form method="POST" action="'.route('assistance_teacher.destroy',$data->id).'"> 
                                                <input type="hidden" name="_token" value="'.csrf_token().'" autocomplete="off">                    
                                                <input type="hidden" name="_method" value="DELETE">
                                              <button type="submit" class="btn btn-danger">Si</button>
                                            </form>
                                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">No</button>
                                          </div>
                                        </div>
                                      </div>
                                    </div>'
                                    ;
                                    return $links;
                                })
                                ->rawColumns(['action'])
                                ->make(true);
        }
        return view('assistance_teacher.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //dd(date('Y-m-d H:i', time()));
        $periods = Period::get();

        $teachers = DB::table('teachers')->orderBy('lastname','asc')->get();
        return view('assistance_teacher.create',['teachers' => $teachers, 'periods' => $periods]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAssistanceTeacherRequest $request)
    {
        //dd($request->collect());
        //dd($request->input('educational-platforms'));
        //$newDateTime = date('Y-m-d H:i:s', strtotime($request->input('checkin-time')));
        //dd($newDateTime);

        //$string_version = implode(',', $request->input('educational-platforms'));
        //dd($string_version);
        //$destination_array = explode(',', $string_version);
        //dd($destination_array);

        $validated = $request->validate([
            'teacher-id' => 'required',
            'training-module' => 'required',
            'period' => 'required',
            'turn' => 'required',
            'didactic-unit' => 'required',
            //'checkin-time' => 'required',
            //'departure-time' => 'required',
            'theme' => 'required',
            'place' => 'required',
        ]);

        //dd($request->input('departure-time'));
        //dd( date('Y-m-d H:i:s', strtotime($request->input('departure-time'))) );

        //dd($request->collect());

        AssistanceTeacher::insert([
            'teacher_id' => $request->input('teacher-id'),
            'training_module' => $request->input('training-module'),
            'period' => $request->input('period'),
            'turn' => $request->input('turn'),
            'didactic_unit' => $request->input('didactic-unit'),
            'checkin_time' => date('Y-m-d H:i:s', strtotime($request->input('checkin-time'))),
            'departure_time' => date('Y-m-d H:i:s', strtotime($request->input('departure-time'))),
            'theme' => $request->input('theme'),
            'place' => $request->input('place'),
            'educational_platforms' => $request->input('educational-platforms') ? implode(', ', $request->input('educational-platforms')) : null,
            'remarks' => $request->input('remarks'),
            'remember_token' => Str::random(10),
        ]);

        return redirect(route('assistance_teacher'))->with('success', 'Asistencia registrada');
    }

    /**
     * Display the specified resource.
     */
    public function show(AssistanceTeacher $assistanceTeacher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AssistanceTeacher $assistanceTeacher)
    {
        $edplat = $assistanceTeacher->educational_platforms ? explode(', ',$assistanceTeacher->educational_platforms) : [];
        //dd($edplat);

        /*if(in_array("holo", $edplat))
            dd("funciona");
        else dd("No hay");*/
        $periods = Period::get();

        return view('assistance_teacher.edit',['assistance_teacher' => $assistanceTeacher, 'edplat' => $edplat, 'periods' => $periods]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAssistanceTeacherRequest $request, AssistanceTeacher $assistanceTeacher)
    {
        //dd($request->collect());

        /*$validated = $request->validate([
            'teacher-id' => 'required',
            'training-module' => 'required',
            'period' => 'required',
            'turn' => 'required',
            'didactic-unit' => 'required',
            //'checkin-time' => 'required',
            //'departure-time' => 'required',
            'theme' => 'required',
            'place' => 'required',
        ]);*/

        //dd($request->collect());

        /*$data = $validated;
        $data['checkin_time'] = date('Y-m-d H:i:s', strtotime($data['checkin_time']));
        $data['departure_time'] = date('Y-m-d H:i:s', strtotime($data['departure_time']));
        $data['educational_platforms'] = implode(', ', $data['educational_platforms']);

        $assistanceTeacher->update($data);*/

        /*$data = AssistanceTeacher::find($assistanceTeacher->id);
        $data->update([
            'training_module' => $request->input('training-module'),
            'period' => $request->input('period'),
            'turn' => $request->input('turn'),
            'didactic_unit' => $request->input('didactic-unit'),
            'checkin_time' => date('Y-m-d H:i:s', strtotime($request->input('checkin-time'))),
            'departure_time' => date('Y-m-d H:i:s', strtotime($request->input('departure-time'))),
            'theme' => $request->input('theme'),
            'place' => $request->input('place'),
            'educational_platforms' => implode(', ', $request->input('educational-platforms')),
            'remarks' => $request->input('remarks'),
        ]);
        dd($data);*/
        //dd($request->input('educational-platforms'));

        $assistanceTeacher->training_module = $request->input('training-module');
        $assistanceTeacher->period = $request->input('period');
        $assistanceTeacher->turn = $request->input('turn');
        $assistanceTeacher->didactic_unit = $request->input('didactic-unit');
        $assistanceTeacher->checkin_time = date('Y-m-d H:i:s', strtotime($request->input('checkin-time')));
        $assistanceTeacher->departure_time = date('Y-m-d H:i:s', strtotime($request->input('departure-time')));
        $assistanceTeacher->theme = $request->input('theme');
        $assistanceTeacher->place = $request->input('place');
        $assistanceTeacher->educational_platforms = $request->input('educational-platforms') ? implode(', ', $request->input('educational-platforms')) : null;
        $assistanceTeacher->remarks = $request->input('remarks');

        $assistanceTeacher->save();

        return redirect(route('assistance_teacher'))->with('success', 'Registro cambiado');
        //->with('success','Product updated successfully')
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AssistanceTeacher $assistanceTeacher)
    {
        //dd($assistanceTeacher);
        $assistanceTeacher->delete();
        return redirect(route('assistance_teacher'))->with('success', 'Registro eliminado');
    }
}
