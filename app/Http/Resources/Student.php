<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Student extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'batch_id' => $this->batch_id,
            'batch' => $this->batch->name,
            'name' => $this->name,
            'address' => $this->address,
            'email' => $this->email,
            'phone' => $this->phone,
            'dob' => $this->dob,
            'enroll_no' => $this->enroll_no,
            'exam_no' => $this->exam_no,
            'enrolled_year' => $this->enrolled_year,
            'year_of_completion' => $this->year_of_completion,
            'ug_institute' => $this->ug_institute,
            'thesis_subject' => $this->thesis_subject,
            'status' => $this->status,
            'profile' => $this->profile()
        ];
    }
}
