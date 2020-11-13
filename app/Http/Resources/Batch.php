<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class Batch extends JsonResource
{

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'start' => Carbon::parse($this->start)->format('F d, Y'),
            'end' => Carbon::parse($this->end)->format('F d, Y'),
            'students' => count($this->students),
            'created_at' => date('F d, Y g:i A', strtotime($this->created_at)),
            'created_timestamp' => Carbon::parse($this->created_at)->diffForHumans()
        ];
    }
}
