<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\AssistanceTeacher;
use Illuminate\Support\Facades\DB;
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
        Teacher::insert([
            'name' => $request->input('name'),
            'lastname' => $request->input('lastname')
        ]);
        return redirect(route('teacher'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Teacher $teacher, Request $request)
    {
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
                                    return date('h:i A', strtotime($data->checkin_time));
                                })
                                ->editColumn('departure_time', function(AssistanceTeacher $data) {
                                    return date('h:i A', strtotime($data->departure_time));
                                })
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
        //
    }
}
