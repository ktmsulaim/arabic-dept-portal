<?php

namespace App\Http\Controllers;

use App\Http\Resources\Job as ResourcesJob;
use App\Job;
use App\Student;
use Illuminate\Http\Request;

class JobController extends Controller
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
     * Display a list of resource by student
     */
    public function getByStudent(Student $student)
    {
        $jobs = $student->jobs;
        return ResourcesJob::collection($jobs);
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
        $job = Job::create($this->data());
        return new ResourcesJob($job);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function show(Job $job)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function edit(Job $job)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Job $job)
    {
        $job->update($this->data());
        $job->fresh();
        return new ResourcesJob($job);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function destroy(Job $job)
    {
        if ($job->delete()) {
            return response([], 204);
        }
    }

    private function data()
    {
        return request()->validate([
            'student_id' => 'required|integer',
            'name' => 'required',
            'place' => 'required',
            'start_date' => 'required',
            'end_date' => 'required_if:status,0',
            'status' => 'required|integer'
        ]);
    }
}
