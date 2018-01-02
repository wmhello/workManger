<?php

namespace App\Http\Controllers;

use App\ClassTeacher;
use App\Http\Controllers\Import\ClassTeacherImport;
use App\Http\Requests\ClassTeacherRequest;
use App\Http\Requests\ClassTeacherUploadRequest;
use App\Http\Resources\ClassTeacherCollection;
use App\Session;
use Illuminate\Http\Request;

class ClassTeacherController extends Controller
{
    use Result, Tools;

    /**
     * @api {get} /api/classTeacher 获取班主任列表
     * @apiGroup classTeacher
     *
     * @apiParam {number} [session_id] 学期ID 默认为当前学期
     * @apiParam {number} [teacher_id] 教师ID 默认为空
     * @apiSuccessExample 获取班主任列表，分页显示，每页15条记录,
     * HTTP/1.1 200 OK
     * {
     * "data": [
     * {
     * "id": 1,
     * "session_id": 3,
     * "teacher_id": 140,
     * "grade": 1,
     * "class": 1,
     * "remark": null
     * }
     * ],
     * "status": "success",
     * "status_code": 200,
     * "links": {
     * "first": "http://manger.test/api/classTeacher?page=1",
     * "last": "http://manger.test/api/classTeacher?page=1",
     * "prev": null,
     * "next": null
     * },
     * "meta": {
     * "current_page": 1,
     * "from": 1,
     * "last_page": 1,
     * "path": "http://manger.test/api/classTeacher",
     * "per_page": 15,
     * "to": 13,
     * "total": 13
     * }
     * }
     */
    public function index(Request $request)
    {
        $data = $request->only(['session_id', 'page', 'pageSize', 'teacher_id']);
        $pageSize = $data['pageSize']??15;
        $teacher_id = $data['teacher_id']??null;
        $session_id = $data['session_id']??$this->getCurrentSessionId();
        if ($teacher_id && $session_id) {
            $lists = ClassTeacher::where('teacher_id', $teacher_id)->where('session_id',$session_id)->paginate($pageSize);
        }
        if (! $teacher_id && $session_id) {
            $lists = ClassTeacher::where('session_id',$session_id)->paginate($pageSize);
        }
        return new ClassTeacherCollection($lists);
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
     * @api {post} /api/classTeacher 创建新的班主任信息
     * @apiGroup classTeacher
     *
     * @apiParam {number} session_id 学期ID
     * @apiParam {number} teacher_id 教师ID
     * @apiParam {number} class 班级
     * @apiParam {number=1,2,3} grade 年级
     * @apiParam {string} [remark] 备注 可选
     * @apiParamExample {object} 请求事例 创建新的班主任信息:
     * {
     * session_id: 3,
     * teacher_id: 168,
     * class: 10,
     * grade: 1,
     * remark: '高一10班'
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
     * @apiErrorExample {json} 指定的班级不存在:
     * HTTP/1.1 416 Satisfiable
     * {
     * "status": 'error',
     * "status_code": 416,
     * "message": '数据校验出错，指定的班级不存在'
     * }
     * @apiErrorExample {json} 操作失败:
     * HTTP/1.1 404 Not Found
     * {
     * "status": "error",
     * "status_code": 404
     * }
     */
    public function store(ClassTeacherRequest $request)
    {
        //
        $data = $request->only(['session_id', 'teacher_id', 'grade', 'class', 'remark']);
        if (! $this->checkClass($data)) {
          return $this->errorWithCodeAndInfo(416, '数据校验出错，指定的班级不存在');
        };
        if (ClassTeacher::create($data)) {
            return $this->success();
        } else {
            return $this->error();
        }
    }

    /**
     * @api {get} /api/classTeacher/:id 获取指定的班主任信息
     * @apiGroup classTeacher
     *
     * @apiParam {number} id 班主任标识ID
     * @apiSuccessExample 获取班主任列表，分页显示，每页15条记录,
     * HTTP/1.1 200 OK
     * {
     * "data": [
     * {
     * "id": 1,
     * "session_id": 3,
     * "teacher_id": 140,
     * "grade": 1,
     * "class": 1,
     * "remark": null
     * }
     * ],
     * "status": "success",
     * "status_code": 200
     * }
     */
    public function show(ClassTeacher $classTeacher)
    {
        //
        return new \App\Http\Resources\ClassTeacher($classTeacher);
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
     * @api {patch} /api/classTeacher/:id 更新指定的班主任信息
     * @apiGroup classTeacher
     *
     * @apiParam {number} id 班主任标识
     * @apiParam {number} session_id 学期ID
     * @apiParam {number} teacher_id 教师ID
     * @apiParam {number} class 班级
     * @apiParam {number=1,2,3} grade 年级
     * @apiParam {string} [remark] 备注 可选
     * @apiParamExample {object} 请求事例 创建新的班主任信息
     * {
     * id: 15,
     * session_id: 3,
     * teacher_id: 168,
     * class: 10,
     * grade: 1,
     * remark: '高一10班'
     * }
     *
     * @apiSuccessExample {json} 操作成功
     * HTTP/1.1 200 OK
     * {
     * "status": "success",
     * "status_code": 200
     * }
     * @apiErrorExample {json} 数据验证出错
     * HTTP/1.1 422 Not Found
     * {
     * "status": 422,
     * }
     * @apiErrorExample {json} 指定的班级不存在
     * HTTP/1.1 416 Satisfiable
     * {
     * "status": 'error',
     * "status_code": 416,
     * "message": '数据校验出错，指定的班级不存在'
     * }
     * @apiErrorExample {json} 操作失败
     * HTTP/1.1 404 Not Found
     * {
     * "status": "error",
     * "status_code": 404
     * }
     */

    public function update(ClassTeacherRequest $request, ClassTeacher $classTeacher)
    {
        //
        $data = $request->only(['session_id', 'teacher_id', 'grade', 'class', 'remark']);
        if (! $this->checkClass($data)) {
            return $this->errorWithCodeAndInfo(416, '数据校验出错，指定的班级不存在');
        };
        $classTeacher->session_id = $data['session_id'];
        $classTeacher->teacher_id = $data['teacher_id'];
        $classTeacher->grade = $data['grade'];
        $classTeacher->class = $data['class'];
        $classTeacher->remark = $data['remark'];
        if ($classTeacher->save()) {
            return $this->success();
        } else {
            return $this->error();
        }
    }

    /**
     * @api {delete} /api/classTeacher/:id 删除指定的班主任信息
     * @apiGroup classTeacher
     *
     * @apiParam {number} id 班主任标识

     * @apiSuccessExample {json} 操作成功
     * HTTP/1.1 200 OK
     * {
     * "status": "success",
     * "status_code": 200
     * }
     * @apiErrorExample {json} 操作失败 指定的信息不存在
     * HTTP/1.1 404 Not Found
     * {
     * "status": "error",
     * "status_code": 404
     * }
     */

    public function destroy(ClassTeacher $classTeacher)
    {
        //
        if ($classTeacher->delete()) {
            return $this->success();
        } else {
            return $this->error();
        }
    }

    /**
     * @api {post} /api/classTeacher/upload 导入班主任信息
     * @apiGroup classTeacher
     *
     * @apiParam {number} session_id 学期ID
     * @apiParam {string} file 要导入的文件

     * @apiHeaderExample {json} http头部例子
     *     {
     *       "content-type": "multipart/form-data"
     *     }
     *
     * @apiParamExample {object} 请求事例 导入指定学期的班主任数据
     * {
     * session_id: 3,
     * file: 'd:/3.xls'
     * }
     *
     * @apiSuccessExample {json} 操作成功
     * HTTP/1.1 200 OK
     * {
     * "status": "success",
     * "status_code": 200
     * }
     * @apiErrorExample {json} 操作失败
     * HTTP/1.1 404 Not Found
     * {
     * "status": "error",
     * "status_code": 404
     * }
     */

    public function upload( ClassTeacherImport $import, ClassTeacherUploadRequest $request)
    {
        $bool = $import->handleImport($import);
        if ($bool) {
            return $this->success();
        } else {
            return $this->error();
        }
    }

    /**
     * 验证是否存在指定的班级 如果该学期的指定年级 没有指定的班级，则显示数据校验出错
     * @param $data
     * @return bool|\Illuminate\Http\JsonResponse
     */

    protected function checkClass($data)
    {
        list($session_id, $class, $grade) = [(int)$data['session_id'], (int)$data['class'], (int)$data['grade']];
        $session = Session::where('id', $session_id)->first()->toArray();
        $arrGrade = ['zero', 'one', 'two', 'three'];
        $maxClass = $session[$arrGrade[$grade]];
        if ($class > $maxClass || $class <=0) {
            return false;
        } else {
            return true;
        }
    }
}
