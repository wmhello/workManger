<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Import\LeaderImport;
use App\Http\Requests\LeaderRequest;
use App\Http\Requests\LeaderUploadRequest;
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
        $data = $request->only(['pageSize', 'page', 'name', 'session_id']);
       $pageSize = $data['pageSize']??15;
       $name = nullata['name']??null;
       $session_id = $data['session_id']??null;
       $page = $data['page']??1;
      if ($name && $session_id) {
          $lists = Leader::where('name', $name)->where('session_id',$session_id)->paginate($pageSize);
      }
      if (! $name && $session_id) {
          $lists = Leader::where('session_id',$session_id)->paginate($pageSize);
      }
      if ($name && !$session_id) {
            $lists = Leader::where('name', $name)->paginate($pageSize);
       }


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
