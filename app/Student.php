<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['batch_id', 'name', 'address', 'email', 'phone', 'enrolled_year', '']
}
