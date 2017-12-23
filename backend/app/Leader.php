<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Leader extends Model
{
    //
    protected $fillable = ['session_id', 'teacher_id', 'leader_type', 'job', 'remark'];
}
