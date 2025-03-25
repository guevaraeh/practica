<?php

namespace App\Http\Controllers;

use App\Models\AssistanceTeacher;
use Illuminate\Support\Facades\DB;
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
                ->select([DB::raw("CONCAT(teachers.name,' ',teachers.lastname) as teacher_name"),'assistance_teachers.*'])
                ->join('teachers', 'assistance_teachers.teacher_id', '=', 'teachers.id')
                ->orderBy('assistance_teachers.id', 'desc');
            return DataTables::eloquent($assistance_teachers)
                                /*->addColumn('teacher_name',function (AssistanceTeacher $data){
                                    return $data->teacher->lastname .' '. $data->teacher->name;
                                })*/
                                ->filterColumn('teacher_name', function($query, $keyword) {
                                    $sql = "CONCAT(teachers.name,' ',teachers.lastname) like ?";
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
                                    $links = '
                                      <a href="'.route('assistance_teacher.edit',$data->id).'">Editar</a>
                                    ';
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

        $teachers = DB::table('teachers')->orderBy('lastname','asc')->get();
        return view('assistance_teacher.create',['teachers' => $teachers]);
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
            'educational_platforms' => implode(', ', $request->input('educational-platforms')),
            'remarks' => $request->input('remarks'),
            'remember_token' => $request->input('_token'),
        ]);

        return redirect(route('assistance_teacher'));
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAssistanceTeacherRequest $request, AssistanceTeacher $assistanceTeacher)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AssistanceTeacher $assistanceTeacher)
    {
        //
    }
}
