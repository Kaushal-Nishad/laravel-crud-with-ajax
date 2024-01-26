<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Classes;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::select('students.*','classes.name as class_name')->latest('id')
                    ->leftJoin('classes','classes.id','=','students.student_class')
                    ->paginate(5);
        return view('index',['students'=>$students]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $class_list = Classes::latest()->get();
        return view('create',['classes'=>$class_list]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'class' => 'required|integer',
            'age' => 'required|integer|max:50|min:18',
            'gender' => 'required|string',
        ]);

        $student = new Student;
        $student->student_name = $request->name;
        $student->student_class = $request->class;
        $student->student_age = $request->age;
        $student->student_gender = $request->gender;
        $student->save();
        return '1';
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $class_list = Classes::latest()->get();
        $student = Student::find($id);

        return view('edit',['student'=>$student,'classes'=>$class_list]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'class' => 'required|integer',
            'age' => 'required|integer|max:50|min:18',
            'gender' => 'required|string',
        ]);

        $student= Student::where(['id'=>$id])->update([
            'student_name'=>$request->input('name'),
            'student_class'=>$request->input('class'),
            'student_age'=>$request->input('age'),
            'student_gender'=>$request->input('gender'),
        ]);
        return '1';
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $destroy = Student::where('id',$id)->delete();
        return $destroy;
    }
}
