<?php

namespace App\Http\Controllers;

use App\Http\Resources\Photo as ResourcesPhoto;
use App\Http\Resources\Student as ResourcesStudent;
use App\Photo;
use App\Student;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Get photos of a specific student
     * 
     * @param int $student_id
     * @return \Illuminate\Http\Response
     */
    public function getByStudent(Student $student)
    {
        $photos = $student->photos;
        return ResourcesPhoto::collection($photos);
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
        $filename = Photo::createFromBase64($request->filename);

        if ($request->status == 1) {
            $student = Student::find($request->student_id);
            $this->clearDefault($student);
        }

        $photo = Photo::create([
            'student_id' => $request->student_id,
            'filename' => $filename,
            'status' => $request->status
        ]);

        return new ResourcesPhoto($photo);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function show(Photo $photo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function edit(Photo $photo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Photo $photo)
    {
        $photo->update($request->all());
        $photo->fresh();
        return $photo;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Photo $photo)
    {
        $photo->deleteWithFile();
        $student = $photo->student;
        return new ResourcesStudent($student);
    }


    private function clearDefault(Student $student)
    {
        foreach ($student->photos as $key => $photo) {
            $photo->update(['status' => 0]);
        }
    }

    public function makeProfile(Photo $photo)
    {
        $student = $photo->student;
        $this->clearDefault($student);
        $photo->update(['status' => 1]);
        $photo->fresh();
        return new ResourcesPhoto($photo);
    }
}
