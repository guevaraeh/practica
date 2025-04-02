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
use Maatwebsite\Excel\Facades\Excel;
use DataTables;
use Illuminate\Support\Facades\Gate;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /*if (!Gate::allows('manage-assistance')) {
            abort(403);
        }*/

        $teachers = Teacher::orderBy('lastname', 'asc')->get();
        return view('teacher.index',['teachers' => $teachers]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        /*if (!Gate::allows('manage-assistance')) {
            abort(403);
        }*/

        return view('teacher.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTeacherRequest $request)
    {
        /*if (!Gate::allows('manage-assistance')) {
            abort(403);
        }*/

        $validated = $request->validate([
            'name' => 'required|max:100',
            'lastname' => 'required|max:100',
        ]);

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
        /*if (!Gate::allows('manage-assistance')) {
            abort(403);
        }*/

        if($request->ajax())
        {
            $assistance_teachers = AssistanceTeacher::query()
                ->where('teacher_id', $teacher->id)
                ->orderBy('id', 'desc');
            return DataTables::eloquent($assistance_teachers)
                                ->editColumn('created_at', function(AssistanceTeacher $data) {
                                    return date('Y-m-d h:i A', strtotime($data->created_at));
                                })
                                ->editColumn('checkin_time', function(AssistanceTeacher $data) {
                                    return date('Y-m-d h:i A', strtotime($data->checkin_time));
                                })
                                ->editColumn('departure_time', function(AssistanceTeacher $data) {
                                    return date('Y-m-d h:i A', strtotime($data->departure_time));
                                })
                                ->filterColumn('created_at', function($query, $keyword) {
                                    $sql = "DATE_FORMAT(created_at, '%Y/%m/%d %r') like ?";
                                    $query->whereRaw($sql, ["%{$keyword}%"]);
                                })
                                ->filterColumn('checkin_time', function($query, $keyword) {
                                    $sql = "DATE_FORMAT(checkin_time, '%Y/%m/%d %r') like ?";
                                    $query->whereRaw($sql, ["%{$keyword}%"]);
                                })
                                ->filterColumn('departure_time', function($query, $keyword) {
                                    $sql = "DATE_FORMAT(departure_time, '%Y/%m/%d %r') like ?";
                                    $query->whereRaw($sql, ["%{$keyword}%"]);
                                })
                                ->addColumn('action',function (AssistanceTeacher $data){
                                    $updated = '';
                                    if(strtotime($data->created_at) < strtotime($data->updated_at)){
                                        $updated = 
                                        '<tr>
                                            <th><small>Editado</small></th>
                                            <td><small>'.date('Y-m-d h:i A', strtotime($data->updated_at)).'</small></td>
                                        </tr>';
                                    }
                                    $links = 
                                    '<div class="btn-group" role="group" aria-label="Basic mixed styles example">'.
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
                                                    <table class="table table-hover">
                                                        <tbody>
                                                            <tr>
                                                                <th><small>Módulo Formativo</small></th>
                                                                <td><small>'.$data->training_module.'</small></td>
                                                            </tr>
                                                            <tr>
                                                                <th><small>Período Académico</small></th>
                                                                <td><small>'.$data->period.'</small></td>
                                                            </tr>
                                                            <tr>
                                                                <th><small>Turno/Sección</small></th>
                                                                <td><small>'.$data->turn.'</small></td>
                                                            </tr>
                                                            <tr>
                                                                <th><small>Unidad Didáctica</small></th>
                                                                <td><small>'.$data->didactic_unit.'</small></td>
                                                            </tr>
                                                            <tr>
                                                                <th><small>Hora de ingreso</small></th>
                                                                <td><small>'.date('Y-m-d h:i A', strtotime($data->checkin_time)).'</small></td>
                                                            </tr>
                                                            <tr>
                                                                <th><small>Hora de salida</small></th>
                                                                <td><small>'.date('Y-m-d h:i A', strtotime($data->departure_time)).'</small></td>
                                                            </tr>
                                                            <tr>
                                                                <th><small>Tema de actividad de aprendizaje</small></th>
                                                                <td><small>'.$data->theme.'</small></td>
                                                            </tr>
                                                            <tr>
                                                                <th><small>Lugar de realización de actividad</small></th>
                                                                <td><small>'.$data->place.'</small></td>
                                                            </tr>
                                                            <tr>
                                                                <th><small>Plataformas educativas de apoyo</small></th>
                                                                <td><small>'.$data->educational_platforms.'</small></td>
                                                            </tr>
                                                            <tr>
                                                                <th><small>Observaciones</small></th>
                                                                <td><small>'.$data->remarks.'</small></td>
                                                            </tr>
                                                            '.$updated.'
                                                        </tbody>
                                                    </table>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>'
                                    .
                                    '<a type="button" href="'.route('assistance_teacher.edit',$data->id).'" class="btn btn-info" title="Editar"><i class="bi-pencil"></i></a>'
                                    .
                                    '<button type="button" class="btn btn-danger swalDefaultSuccess" form="deleteall" formaction="'.route('assistance_teacher.destroy',$data->id).'" value="'.date('Y-m-d h:i A', strtotime($data->created_at)).'" title="Eliminar"><i class="bi-trash"></i></button>'
                                    .'</div>'
                                    ;
                                    return $links;
                                })
                                ->rawColumns(['action'])
                                ->make(true);
        }

        return view('teacher.show',['teacher' => $teacher, 'periods' => Period::get()]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Teacher $teacher)
    {
        /*if (!Gate::allows('manage-assistance')) {
            abort(403);
        }*/

        return view('teacher.edit',['teacher' => $teacher]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTeacherRequest $request, Teacher $teacher)
    {
        /*if (!Gate::allows('manage-assistance')) {
            abort(403);
        }*/

        $teacher->name = $request->input('name');
        $teacher->lastname = $request->input('lastname');
        $teacher->save();

        return redirect(route('teacher'))->with('success', 'Profesor editado');
    }

    public function create_assistance(Teacher $teacher)
    {
        $teachers = DB::table('teachers')->orderBy('lastname','asc')->get();
        return view('assistance_teacher.create',['teachers' => $teachers, 'periods' => Period::get(), 'tch' => $teacher]);
    }

    public function export(Teacher $teacher) 
    {
        /*if (!Gate::allows('manage-assistance')) {
            abort(403);
        }*/

        return AssistanceTeacher::query()
            ->select([
                DB::raw("DATE_FORMAT(created_at, '%Y/%m/%d %r')"),
                'training_module',
                'period',
                'turn',
                'didactic_unit',
                DB::raw("DATE_FORMAT(checkin_time, '%Y/%m/%d %r')"),
                DB::raw("DATE_FORMAT(departure_time, '%Y/%m/%d %r')"),
                'theme',
                'place',
                'educational_platforms',
                'remarks',
                ]) //periods.name
            ->where('teacher_id', $teacher->id)
            ->orderBy('id', 'desc')
            ->downloadExcel('Asistencias_'.$teacher->lastname.'_'.$teacher->name.'_'.date('YmdHi', time()).'.xlsx');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Teacher $teacher)
    {
        /*if (!Gate::allows('manage-assistance')) {
            abort(403);
        }*/

        foreach ($teacher->assistances as $assistance)
            $assistance->delete();
        $teacher->delete();
        return redirect(route('teacher'))->with('success', 'Profesor eliminado con sus registros');
    }
}
