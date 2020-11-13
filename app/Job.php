<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $guarded = [];

    public function student()
    {
        return $this->belongsTo('App\Student');
    }

    public function setStartDateAttribute($val)
    {
        if ($val) {
            $this->attributes['start_date'] = Carbon::parse($val)->format('F d, Y');
        }
    }

    public function setEndDateAttribute($val)
    {
        if ($val) {
            $this->attributes['end_date'] = Carbon::parse($val)->format('F d, Y');
        }
    }
}
