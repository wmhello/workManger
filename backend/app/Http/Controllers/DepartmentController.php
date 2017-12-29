<?php

namespace App\Http\Controllers;

use App\Department;
use App\Http\Controllers\Import\DepartmentImport;
use App\Http\Requests\DepartmentRequest;
use App\Http\Requests\DepartmentsUploadRequest;
use App\Http\Resources\DepartmentCollection;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    use Result;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $data = $request->only(['session_id', 'page', 'pageSize', 'teacher_id', 'leader']);
        $pageSize = $data['pageSize']??15;
        $teacher_id = $data['teacher_id']??null;
        $session_id = $data['session_id']??null;
        $leader = $data['leader']??[1,0];
        if ($teacher_id && $session_id) {
            $lists = Department::where('teacher_id', $teacher_id)->where('session_id',$session_id)->whereIn('id', $leader)->paginate($pageSize);
        }
        if (! $teacher_id && $session_id) {
            $lists = Department::where('session_id',$session_id)->whereIn('id', $leader)->paginate($pageSize);
        }
        if ($teacher_id && !$session_id) {
            $lists = Department::where('teacher_id', $teacher_id)->whereIn('id', $leader)->paginate($pageSize);
        }
        return new DepartmentCollection($lists);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DepartmentRequest  $request)
    {
        //
        $data = $request->only(['session_id', 'teacher_id', 'teach_id', 'leader', 'grade', 'remark']);
        if (Department::create($data)) {
            return $this->success();
        } else {
            return $this->error();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {
        //
        return new \App\Http\Resources\Department($department);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(DepartmentRequest $request, Department $department)
    {
        //
        $data = $request->only(['session_id', 'teacher_id', 'teach_id', 'leader', 'grade', 'remark']);
        $department->session_id = $data['session_id'];
        $department->teacher_id = $data['teacher_id'];
        $department->teach_id = $data['teach_id'];
        $department->leader = $data['leader'];
        $department->grade = $data['grade'];
        $department->remark = $data['remark'];
        if ($department -> save() ) {
            return $this->success();
        } else {
            return $this->error();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        //
        if ($department->delete()) {
            return $this->success();
        } else {
            return $this->error();
        }
    }

    public function upload(DepartmentImport $import, DepartmentsUploadRequest $request)
    {
        $bool = $import->handleImport($import);
        if ($bool) {
            return $this->success();
        } else {
            return $this->error();
        }
    }
}
