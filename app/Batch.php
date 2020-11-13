<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $fillable = ['name', 'start', 'end',];

    public function students()
    {
        return $this->hasMany('App\Student');
    }

    public function setStartAttribute($val)
    {
        if ($val) {
            return $this->attributes['start'] = Carbon::parse($val);
        }
    }

    public function setEndAttribute($val)
    {
        if ($val) {
            return $this->attributes['end'] =  Carbon::parse($val);
        }
    }
}
