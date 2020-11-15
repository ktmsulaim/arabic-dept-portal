<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Photo extends JsonResource
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
            'path' => $this->path(),
            'filename' => $this->filename,
            'status' => $this->status,
            'date' => $this->created_at->format('M d, Y'),
            'time' => $this->created_at->format('g:i A')
        ];
    }
}
