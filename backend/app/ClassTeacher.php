<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassTeacher extends Model
{
    //
    protected $fillable = ['session_id', 'teacher_id', 'grade', 'class', 'remark'];
}
