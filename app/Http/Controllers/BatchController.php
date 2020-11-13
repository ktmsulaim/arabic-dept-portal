<?php

namespace App\Http\Controllers;

use App\Http\Resources\Batch as BatchCollection;
use App\Batch;
use App\Http\Resources\Student;
use Illuminate\Http\Request;

class BatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $batches = Batch::all();
        return BatchCollection::collection($batches);
    }

    /**
     * Display students by batch
     * 
     * @param Batch $batch
     * @return \Illuminate\Http\Response
     */

    public function getStudents(Batch $batch)
    {
        $students = $batch->students;

        return Student::collection($students);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'start' => 'required',
            'end' => 'required'
        ]);

        $batch = Batch::create($data);
        return new BatchCollection($batch);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Batch  $batch
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $batch = Batch::findOrFail($id);
        return new BatchCollection($batch);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Batch  $batch
     * @return \Illuminate\Http\Response
     */
    public function edit(Batch $batch)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Batch  $batch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $batch = Batch::findOrFail($id);

        // Validate input data
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'start' => 'required',
            'end' => 'required'
        ]);

        $batch->update($data);
        return new BatchCollection($batch);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Batch  $batch
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $batch = Batch::findOrFail($id);

        if ($batch->delete()) {
            return response(new BatchCollection($batch), 200);
        } else {
            return response(new BatchCollection($batch), 500);
        }
    }
}
