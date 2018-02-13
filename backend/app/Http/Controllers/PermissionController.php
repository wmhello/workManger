<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermissionRequest;
use App\Http\Resources\PermissionCollection;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
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
        $pageSize = $request->input('pageSize', 10);
        $lists  = Permission::Name()->Pid()->Type()->paginate($pageSize);
        return new PermissionCollection($lists);
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
    public function store(PermissionRequest $request)
    {
        //
        $data = $request->only(['name', 'pid', 'type', 'method', 'route_name', 'route_match', 'remark']);

        if (Permission::create($data)){
            return $this->success();
        } else {
            return $this->error();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        //
        return new \App\Http\Resources\Permission($permission);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(PermissionRequest  $request, Permission $permission)
    {
        //
        $data = $request->only(['name', 'pid', 'type', 'method', 'route_name', 'route_match', 'remark']);
        $permission->name = $data['name'];
        $permission->type = $data['type'];
        $permission->method = $data['method'];
        $permission->route_name = $data['route_name'];
        $permission->route_match = isset($data['route_match'])?$data['route_match']:$permission->route_match;
        $permission->remark = isset($data['remark'])?$data['remark']:$permission->remark;
        if ($permission->save()) {
            return $this->success();
        } else {
            return $this->error();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        //
        if ($permission->delete()) {
             return $this->success();
        } else {
             return $this->error();
        }
    }

    public function addGroup(Request $request)
    {
        $data = $request->only(['name', 'remark']);
        $rules = [
            'name' => 'required|unique|string'
        ];
        $messages = [
            'name.requried' => '功能组名称必须填写',
            'name.unique' => '功能组名称已经存在，无法建立'
        ];
        Validator::make($data, $rules, $messages);

        $data['pid'] = 0;
        $data['type'] = 1;
        if (Permission::create($data)) {
            return $this->success();
        } else {
            return $this->error();
        }
    }

    public function getGroup()
    {
        $lists = Permission::where('pid', 0)
                            ->where('type', 1)
                            ->get();
        return $this->successWithData($lists);
    }

    public function deleteAll(Request $request)
    {
        $data = $this->deleteByIds($request);
        if ($data) {
            if (Permission::destroy($data['ids'])) {
                return $this->success();
            } else {
                return $this->error();
            }
        }
    }

}
