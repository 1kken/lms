<?php

namespace App\Http\Controllers;

use App\Models\student;
use App\Http\Requests\StorestudentRequest;
use App\Http\Requests\UpdatestudentRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;


class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('student.index', [
            'students' => student::Paginate(5)
        ]);
    }

    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function search(Request $request)
    {
        // Get the search term from the request
        $search = $request->input('search');

        // Initialize the query
        $students = Student::query();

        // Apply the search filter if a search term is provided
        if (!empty($search)) {
            $students->where(function ($query) use ($search) {
                $query->where('name', 'like', "%$search%")
                    ->orWhere('student_id', 'like', "%$search%");
            });
        }

        // Paginate the results (5 items per page)
        $students = $students->paginate(5);

        // Return the view with the search results
        return view('student.index', compact('students'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('student.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorestudentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorestudentRequest $request)
    {
        student::create($request->validated());

        return redirect()->route('students');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\student  $student
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $student = student::find($id)->first();
        return $student;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(student $student)
    {
        return view('student.edit', [
            'student' => $student
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatestudentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatestudentRequest $request, $id)
    {
        $student = student::find($id);
        $student->student_id = $request->student_id;
        $student->name = $request->name;
        $student->address = $request->address;
        $student->gender = $request->gender;
        $student->class = $request->class;
        $student->age = $request->age;
        $student->phone = $request->phone;
        $student->email = $request->email;
        $student->save();

        return redirect()->route('students');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        student::find($id)->delete();
        return redirect()->route('students');
    }
}
