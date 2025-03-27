<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\AssistanceTeacher;
use App\Models\Period;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTeacherRequest;
use App\Http\Requests\UpdateTeacherRequest;
use DataTables;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teachers = Teacher::orderBy('lastname', 'asc')->get();
        return view('teacher.index',['teachers' => $teachers]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('teacher.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTeacherRequest $request)
    {
        //$name = $request->input('name');
        //dd($name);
        //dd($request);
        //return redirect(route('teacher.create'));
        //return url(route('teacher.create'));
        /*Teacher::insert([
            'name' => $request->input('name'),
            'lastname' => $request->input('lastname')
        ]);*/

        $teacher = new Teacher;
        $teacher->name = $request->input('name');
        $teacher->lastname = $request->input('lastname');
        $teacher->remember_token = Str::random(50);
        $teacher->save();

        return redirect(route('teacher'))->with('success', 'Profesor registrado');
    }

    /**
     * Display the specified resource.
     */
    public function show(Teacher $teacher, Request $request)
    {
        /*$dates = [strtotime($teacher->created_at), strtotime($teacher->updated_at)];
        dd($dates);*/
        /*if(strtotime($teacher->created_at) < strtotime($teacher->updated_at))
            dd(1);
        else dd(0);*/
        
        /*$assistances = DB::table('assistance_teachers')->where('teacher_id', $teacher->id)->orderBy('id', 'desc')->paginate(10);
        return view('teacher.show', ['teacher' => $teacher, 'assistances' => $assistances]);*/

        /*$assistances = DB::table('assistance_teachers')->where('teacher_id', $teacher->id)->orderBy('id', 'desc')->get();
        return view('teacher.show', ['teacher' => $teacher, 'assistances' => $assistances]);*/

        if($request->ajax())
        {
            $assistance_teachers = AssistanceTeacher::query()
                ->where('teacher_id', $teacher->id)
                ->orderBy('id', 'desc');
            return DataTables::eloquent($assistance_teachers)
                                ->editColumn('created_at', function(AssistanceTeacher $data) {
                                    return date('Y/m/d h:i A', strtotime($data->created_at));
                                })
                                ->editColumn('checkin_time', function(AssistanceTeacher $data) {
                                    return date('Y/m/d h:i A', strtotime($data->checkin_time));
                                })
                                ->editColumn('departure_time', function(AssistanceTeacher $data) {
                                    return date('Y/m/d h:i A', strtotime($data->departure_time));
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
                                                                <td><small>'.date('Y-m-d h:i A', strtotime($data->updated_at)).'</small></td>
                                                            </tr>';
                                    }
                                    $links = 
                                      '<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal'.$data->id.'" title="Ver">
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

        return view('teacher.show',['teacher' => $teacher]);
    }

    /*public function ajaxshow(Request $request)
    {
        if($request->ajax())
        {
            $assistance_teachers = DB::table('assistance_teachers')->query()
                //->where('teacher_id', 1)
                ->orderBy('id', 'desc');
            return DataTables::eloquent($assistance_teachers)
                                ->make(true);
        }
    }*/

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Teacher $teacher)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTeacherRequest $request, Teacher $teacher)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Teacher $teacher)
    {
        foreach ($teacher->assistances as $assistance)
            $assistance->delete();
        $teacher->delete();
        return redirect(route('teacher'))->with('success', 'Profesor eliminado con sus registros');
    }
}
