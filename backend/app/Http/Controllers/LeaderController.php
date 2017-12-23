<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Import\LeaderImport;
use App\Http\Requests\LeaderUploadRequest;
use App\Leader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
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
    public function update(Request $request, Leader $leader)
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

    public function upload(LeaderUploadRequest $request)
    {
        $fileName = $this->fileUpdate();
        $file = storage_path('app') . '/' . $fileName;
        $lists = [];
        Excel::load($file,function($reader) use(&$data){
             $data = $reader->first()->toArray();
        });

        array_filter($data, function($val) use( &$lists) {
            $item = [
                'name' => $val['name'],
                'type' => (int)$val['type'],
                'job'  => $val['job'],
                'remark'  => $val['remark'],
                'phone'  => $val['phone']
            ];
            $rules = [
                'name' => 'required',
                'phone' => 'present|regex:^13[\d]{9}$|^14[5,7]{1}\d{8}$|^15[^4]{1}\d{8}$|^17[0,6,7,8]{1}\d{8}$|^18[\d]{9}$',
                'type' => 'required|in:1,2'
            ];
            $validator =Validator::make($item,$rules);
            if (!$validator->fails()){ // 成功
                array_push($lists, $item);
            }
        });
        var_dump($lists);
    }

    /**
     * Validate the given parameters with the given rules.
     *
     * @param  array  $parameters
     * @param  array  $rules
     * @param  array  $messages
     * @param  array  $customAttributes
     * @return void
     */
    public function validateParameters($parameters, array $rules, array $messages = [], array $customAttributes = [])
    {
        $validator = $this->getValidationFactory()->make($parameters, $rules, $messages, $customAttributes);

        if ($validator->fails()) {
            $this->throwValidationException(app('request'), $validator);
        }
    }

    /**
     * 抛出一个验证异常
     *
     * @param WrapedValidationException $e
     * @param Request                   $request
     *
     * @throws ValidationException
     */
    protected function throwWrapedValidationException(WrapedValidationException $e, Request $request)
    {
        throw new ValidationException(null, $this->buildFailedValidationResponse($request, $e->getErrors()));
    }

}
