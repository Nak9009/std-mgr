<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'student';

    protected $fillable = [
        'first_name',
        'last_name',
        'student_id',
        'email',
        'phone',
        'address',
        'gender',
        'status',
        'avatar',
        'photo',
    ];
}
