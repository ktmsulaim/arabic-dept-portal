<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $fillable = ['name', 'start', 'end', ];

    public function students()
    {
        return $this->hasMany('App\Student');
    }

}
