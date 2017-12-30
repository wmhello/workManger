<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Import\LeaderImport;
use App\Http\Requests\LeaderRequest;
use App\Http\Requests\LeaderUploadRequest;
use App\Http\Resources\LeaderCollection;
use App\Leader;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\ValidationException;
use \Maatwebsite\Excel\Facades\Excel;

class LeaderController extends Controller
{
    use Result;
    use tools;

    /**
     * @api {get} /api/leader 获取学校行政列表
     * @apiGroup leader
     *
     * @apiParam {number} [session_id] 学期ID
     * @apiParam {number} [teacher_id] 教师ID
     * @apiSuccessExample 获取学校行政列表，分页显示，每页15条记录,
     * HTTP/1.1 200 OK
     * {
     *  "data": [
     *  {
     *  "id": 13,
     *  "session_id": 3,
     *  "teacher_id": 45,
     *  "leader_type": 2,
     *  "job": "校长",
     *  "remark": null
     *  }
     *  ],
     *  "status": "success",
     *  "status_code": 200,
     *  "links": {
     *  "first": "http://manger.test/api/leader?page=1",
     *  "last": "http://manger.test/api/leader?page=1",
     *  "prev": null,
     *  "next": null
     *  },
     *  "meta": {
     *  "current_page": 1,
     *  "from": 1,
     *  "last_page": 1,
     *  "path": "http://manger.test/api/leader",
     *  "per_page": 15,
     *  "to": 3,
     *  "total": 3
     *  }
     *  }
     *
     */

    public function index(Request $request)
    {
        //
        $data = $request->only(['pageSize', 'teacher_id', 'session_id']);
        $pageSize = $data['pageSize']?? 15;
        $teacher_id = $data['teacher_id']?? null;
        $session_id = $data['session_id']??$this->getCurrentSessionId();
      if ($teacher_id && $session_id) {
          $lists = Leader::where('teacher_id', $teacher_id)->where('session_id',$session_id)->paginate($pageSize);
      }
      if (! $teacher_id && $session_id) {
          $lists = Leader::where('session_id',$session_id)->paginate($pageSize);
      }
      if ($teacher_id && !$session_id) {
            $lists = Leader::where('teacher_id', $teacher_id)->paginate($pageSize);
       }
        if (! $teacher_id && !$session_id) {
            $lists = Leader::where('teacher_id', $teacher_id)->where('session_id',$session_id)->paginate($pageSize);
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
     * @api {post}/api/leader 新增学校行政信息
     * @apiGroup leader
     *
     * @apiParam {number} session_id 学期ID
     * @apiParam {number} teacher_id 教师ID
     * @apiParam {number=1,2} leader_type 行政类型(1=>中层 2=>学校)
     * @apiParam {string} [job] 职务描述 可选
     * @apiParam {string} [remark] 备注 可选
     * @apiParamExample {object} 请求事例 建立学期 2017-2018上学期:
     * {
     * session_id: 3,
     * teacher_id: 168,
     * leader_type: 1,
     * job: '教务副主任',
     * remark: ''
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
     * @api {get} /api/leader/:id 获取指定的学校行政信息
     * @apiGroup leader
     *
     * @apiParam {number} id 指定的ID
     *
     * @apiSuccessExample 获取指定的学校行政信息
     * HTTP/1.1 200 OK
     * {
     *  "data": [
     *  {
     *  "id": 13,
     *  "session_id": 3,
     *  "teacher_id": 45,
     *  "leader_type": 2,
     *  "job": "校长",
     *  "remark": null
     *  }
     *  ],
     *  "status": "success",
     *  "status_code": 200,
     *  }
     *
     */
    public function show(Leader $leader)
    {
        //
        return new \App\Http\Resources\Leader($leader);
    }


    public function edit(Leader $leader)
    {
        //
    }


    /**
     * @api {post}/api/leader/id 更新指定的学校行政信息
     * @apiGroup leader
     *
     * @apiParam {number} id 指定的ID
     * @apiParam {number} session_id 学期ID
     * @apiParam {number} teacher_id 教师ID
     * @apiParam {number=1,2} leader_type 行政类型(1=>中层 2=>学校)
     * @apiParam {string} [job] 职务描述 可选
     * @apiParam {string} [remark] 备注 可选
     *
     * @apiParamExample {object} 请求事例 建立学期 2017-2018上学期:
     * {
     * session_id: 3,
     * teacher_id: 168,
     * leader_type: 1,
     * job: '教务副主任',
     * remark: '主管学校教学考试与教育信息化'
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
     * @api {delete} /api/leader/:id 删除指定的学校行政信息
     * @apiGroup leader
     * @apiParam {number} id 标识
     * @apiSuccessExample {json} 删除成功:
     * HTTP/1.1 200 OK
     * {
     * "status": "success",
     * "status_code": 200
     * }
     * @apiErrorExample {json} 删除失败
     * HTTP/1.1 404 Not Found
     * {
     * "status": "error",
     * "status_code": 404
     * }
     * @apiErrorExample {json} 指定的ID不存在，无法处理
     * HTTP/1.1 500 Internal Server Error
     * {
     * "status": "error",
     * "status_code": 500
     * }
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
