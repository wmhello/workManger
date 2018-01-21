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
    use Result,Tools;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * @api {get} /api/department 获取学科组长列表
     * @apiGroup department
     *
     * @apiParam {number} [session_id] 学期ID 默认为当前学期
     * @apiParam {number} [teacher_id] 教师ID
     * @apiParam {number=0,1} [leader] 学科组长 0=>备课组长 1=>学科组长 默认包含所有
     * @apiSuccessExample 获取学科组长列表，分页显示，每页15条记录,
     * HTTP/1.1 200 OK
     * {
     * "data": [
     * {
     * "id": 1,
     * "session_id": 3,
     * "teacher_id": 129,
     * "teach_id": 17,
     * "leader": 0,
     * "grade": 1,
     * "remark": "高一语文"
     * }
     * ],
     * "status": "success",
     * "status_code": 200,
     * "links": {
     * "first": "http://manger.test/api/department?page=1",
     * "last": "http://manger.test/api/department?page=1",
     * "prev": null,
     * "next": null
     * },
     * "meta": {
     * "current_page": 1,
     * "from": 1,
     * "last_page": 1,
     * "path": "http://manger.test/api/department",
     * "per_page": 15,
     * "to": 9,
     * "total": 9
     * }
     * }
     */
    public function index(Request $request)
    {
        //
        $data = $request->only(['session_id', 'page', 'pageSize', 'teacher_id', 'leader']);
        dd($data);
        $pageSize = $data['pageSize']?$data['pageSize']:15;
        $teacher_id = $data['teacher_id']?$data['teacher_id']:null;
        $session_id = $data['session_id']?$data['session_id']:$this->getCurrentSessionId();
        $leader = $data['leader']?$data['leader']:[1,0];
        if ($teacher_id && $session_id) {
            $lists = Department::where('teacher_id', $teacher_id)->where('session_id',$session_id)->whereIn('leader', $leader)->paginate($pageSize);
        }
        if (! $teacher_id && $session_id) {
            $lists = Department::where('session_id',$session_id)->whereIn('leader', $leader)->paginate($pageSize);
        }
        if ($teacher_id && !$session_id) {
            $lists = Department::where('teacher_id', $teacher_id)->whereIn('leader', $leader)->paginate($pageSize);
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

    /**
     * @api {post} /api/department 创建新的学科组长信息
     * @apiGroup department
     *
     * @apiParam {number} session_id 学期ID
     * @apiParam {number} teacher_id 教师ID
     * @apiParam {number=0,1} leader 学科组长类型(0=>备课组长 1=>学科组长)
     * @apiParam {number=1,2,3} grade 年级
     * @apiParam {number} teach_id 科目  结合科目表
     * @apiParam {string} [remark] 备注 可选
     * @apiParamExample {object} 请求事例 建立学期 2017-2018上学期:
     * {
     * session_id: 3,
     * teacher_id: 168,
     * leader: 0,
     * grade: 1,
     * teach_id: 7
     * remark: '高一信息技术'
     * }
     *
     * @apiSuccessExample {json} 操作成功:
     * HTTP/1.1 200 OK
     * {
     * "status": "success",
     * "status_code": 200
     * }
     * @apiErrorExample {json} 数据验证出错:
     * HTTP/1.1 422 Not Found
     * {
     * "status": 422,
     * }
     * @apiErrorExample {json} 操作失败:
     * HTTP/1.1 404 Not Found
     * {
     * "status": "error",
     * "status_code": 404
     * }
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

    /**
     * @api {get} /api/department/:id  获取指定的学科组长信息
     * @apiGroup department
     *
     * @apiParam {number} id 学科组长标识ID
     * @apiSuccessExample 获取指定的学科组长信息
     * HTTP/1.1 200 OK
     * {
     * "data": [
     * {
     * "id": 1,
     * "session_id": 3,
     * "teacher_id": 129,
     * "teach_id": 17,
     * "leader": 0,
     * "grade": 1,
     * "remark": "高一语文"
     * }
     * ],
     * "status": "success",
     * "status_code": 200
     * }
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
    /**
     * @api {patch} /api/department/:id 更新指定的学科组长信息
     * @apiGroup department
     *
     * @apiParam {number} id 学科组长标识ID
     * @apiParam {number} session_id 学期ID
     * @apiParam {number} teacher_id 教师ID
     * @apiParam {number=0,1} leader 学科组长类型(0=>备课组长 1=>学科组长)
     * @apiParam {number=1,2,3} grade 年级
     * @apiParam {number} teach_id 科目  结合科目表
     * @apiParam {string} [remark] 备注 可选
     * @apiParamExample {object} 请求事例 建立学期 2017-2018上学期:
     * {
     * id：10,
     * session_id: 3,
     * teacher_id: 168,
     * leader: 0,
     * grade: 1,
     * teach_id: 7
     * remark: '信息技术'
     * }
     *
     * @apiSuccessExample {json} 操作成功:
     * HTTP/1.1 200 OK
     * {
     * "status": "success",
     * "status_code": 200
     * }
     * @apiErrorExample {json} 数据验证出错:
     * HTTP/1.1 422 Not Found
     * {
     * "status": 422,
     * }
     * @apiErrorExample {json} 操作失败:
     * HTTP/1.1 404 Not Found
     * {
     * "status": "error",
     * "status_code": 404
     * }
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
    /**
     * @api {delete} /api/department/:id 删除指定的学科组长信息
     * @apiGroup department
     *
     * @apiParam {number} id 学科组长标识ID
     *
     * @apiSuccessExample {json} 操作成功:
     * HTTP/1.1 200 OK
     * {
     * "status": "success",
     * "status_code": 200
     * }

     * @apiErrorExample {json} 操作失败，指定的内容已经删除:
     * HTTP/1.1 404 Not Found
     * {
     * "status": "error",
     * "status_code": 404
     * }
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


    /**
     * @api {post} /api/department/upload 导入学科组长信息
     * @apiGroup department
     *
     * @apiParam {number} session_id 学期ID
     * @apiParam {string} file 要导入的文件

     * @apiHeaderExample {json} http头部例子
     *     {
     *       "content-type": "multipart/form-data"
     *     }
     *
     * @apiParamExample {object} 请求事例 导入指定学期的学科组长数据:
     * {
     * session_id: 3,
     * file: 'd:/3.xls'
     * }
     *
     * @apiSuccessExample {json} 操作成功:
     * HTTP/1.1 200 OK
     * {
     * "status": "success",
     * "status_code": 200
     * }
     * @apiErrorExample {json} 操作失败:
     * HTTP/1.1 404 Not Found
     * {
     * "status": "error",
     * "status_code": 404
     * }
     */

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
