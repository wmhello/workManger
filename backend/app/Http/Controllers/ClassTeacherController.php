<?php

namespace App\Http\Controllers;

use App\ClassTeacher;
use App\Http\Controllers\Import\ClassTeacherImport;
use App\Http\Requests\ClassTeacherUploadRequest;
use Illuminate\Http\Request;

class ClassTeacherController extends Controller
{
    use Result;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ClassTeacher  $classTeacher
     * @return \Illuminate\Http\Response
     */
    public function show(ClassTeacher $classTeacher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ClassTeacher  $classTeacher
     * @return \Illuminate\Http\Response
     */
    public function edit(ClassTeacher $classTeacher)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ClassTeacher  $classTeacher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ClassTeacher $classTeacher)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ClassTeacher  $classTeacher
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClassTeacher $classTeacher)
    {
        //
    }

    public function upload( ClassTeacherImport $import, ClassTeacherUploadRequest $request)
    {
        $bool = $import->handleImport($import);
        if ($bool) {
            return $this->success();
        } else {
            return $this->error();
        }
    }
}
