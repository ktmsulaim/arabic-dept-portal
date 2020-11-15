<?php

namespace App\Http\Controllers;

use App\Http\Resources\Student as ResourcesStudent;
use App\Photo;
use App\Student;
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
        $students = Student::all();

        return ResourcesStudent::collection($students);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $student = Student::create($this->data());

        // save photo
        if ($request->image) {
            $filename = Photo::createFromBase64($request->image);
            $student->photos()->create([
                'filename' => $filename,
                'status' => 1
            ]);
        }
        // save jobs
        if ($request->job && count($request->job) > 0) {
            foreach ($request->job as $job) {
                $student->jobs()->create($job);
            }
        }

        return new ResourcesStudent($student);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        return new ResourcesStudent($student);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        $student->update($this->data());
        $student->fresh();
        return new ResourcesStudent($student);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        // delete photos with file not just the db record
        if ($student->photos()->exists()) {
            foreach ($student->photos as $photo) {
                $photo->deleteWithFile();
            }
        }

        $student->delete();
        return response([], 204);
    }

    private function data()
    {
        $data =  request()->validate([
            'batch_id' => 'required|integer',
            'name' => 'required|string',
            'address' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'enrolled_year' => 'required',
            'year_of_completion' => 'required',
            'ug_institute' => 'required',
            'thesis_subject' => 'required',
            'status' => 'required|integer'
        ]);

        $data['dob'] = request()->input('dob');
        $data['enroll_no'] = request()->input('enroll_no');
        $data['exam_no'] = request()->input('exam_no');

        return $data;
    }
}
