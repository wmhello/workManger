<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Import\LeaderImport;
use App\Http\Requests\LeaderRequest;
use App\Http\Requests\LeaderUploadRequest;
use App\Http\Resources\LeaderCollection;
use App\Leader;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\ValidationException;
use \Maatwebsite\Excel\Facades\Excel;

class LeaderController extends Controller
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
        $data = $request->only(['pageSize', 'teacher_id', 'session_id']);
       $pageSize = $data['pageSize']??15;
        $teacher_id = $data['teacher_id']??null;
       $session_id = $data['session_id']??null;
      if ($teacher_id && $session_id) {
          $lists = Leader::where('teacher_id', $teacher_id)->where('session_id',$session_id)->paginate($pageSize);
      }
      if (! $teacher_id && $session_id) {
          $lists = Leader::where('session_id',$session_id)->paginate($pageSize);
      }
      if ($teacher_id && !$session_id) {
            $lists = Leader::where('teacher_id', $teacher_id)->paginate($pageSize);
       }
      return new LeaderCollection($lists);
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
    public function store(LeaderRequest $request)
    {
        //
        $data = $request->only(['session_id', 'teacher_id', 'leader_type', 'job', 'remark']);
        if (Leader::create($data)) {
            return $this->success();
        } else  {
            return $this->error();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Leader  $leader
     * @return \Illuminate\Http\Response
     */
    public function show(Leader $leader)
    {
        //
        return new \App\Http\Resources\Leader($leader);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Leader  $leader
     * @return \Illuminate\Http\Response
     */
    public function edit(Leader $leader)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Leader  $leader
     * @return \Illuminate\Http\Response
     */
    public function update(LeaderRequest $request, Leader $leader)
    {
        //
        $data = $request->only(['session_id', 'teacher_id', 'leader_type', 'job', 'remark']);
        $leader->session_id = $data['session_id'];
        $leader->teacher_id = $data['teacher_id'];
        $leader->leader_type = $data['leader_type'];
        $leader->job = $data['job'];
        $leader->remark = $data['remark'];

        if ($leader->save()) {
            return $this->success();
        } else  {
            return $this->error();
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Leader  $leader
     * @return \Illuminate\Http\Response
     */
    public function destroy(Leader $leader)
    {
        //
        if ($leader->delete()) {
            return $this->success();
        } else {
            return $this->error();
        }
    }

    public function upload( LeaderImport $import,LeaderUploadRequest $request)
    {
           $bool = $import->handleImport($import);
           if ($bool) {
               return $this->success();
           } else {
               return $this->error();
           }
    }



}
