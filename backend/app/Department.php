<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    //
    protected $fillable = ['session_id', 'teacher_id', 'teach_id', 'leader', 'grade', 'remark'];
}
