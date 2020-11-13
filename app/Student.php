<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $guarded = [];

    public function batch()
    {
        return $this->belongsTo('App\Batch');
    }

    public function photos()
    {
        return $this->hasMany('App\Photo');
    }

    public function jobs()
    {
        return $this->hasMany('App\Job');
    }

    public function profile()
    {
        if ($this->photos()->exists()) {
            $photo = $this->photos()->profile()->first();

            if (!$photo) {
                $photo = $this->photos()->latest()->first();
            }

            return asset('uploads/images/' . $photo->filename);
        } else {
            return asset('img/user.png');
        }
    }

    public function setDobAttribute($val)
    {
        if ($val) {
            return $this->attributes['dob'] =  Carbon::parse($val)->format('F d, Y');
        }
    }
}
