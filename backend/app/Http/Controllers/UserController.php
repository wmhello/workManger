<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserCollection;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
   use Result;
    protected $roles = ['admin', 'editor'];

    /**
     * @api {get} /api/admin 显示管理员列表
     * @apiGroup admin
     *
     *
     * @apiSuccessExample 返回管理员信息列表
     * HTTP/1.1 200 OK
     * {
     *  "data": [
     *     {
     *       "id": 2 // 整数型  用户标识
     *       "name": "test"  //字符型 用户昵称
     *       "email": "test@qq.com"  // 字符型 用户email，管理员登录时的email
     *       "role": "admin" // 字符型 角色  可以取得值为admin或editor
     *       "avatar": "" // 字符型 用户的头像图片
     *     }
     *   ],
     * "status": "success",
     * "status_code": 200
     * }
     *
     */
    public function index()
    {
        //
        $users = User::all();
        return new UserCollection($users);
    }


    public function create(Request $request)
    {

    }

    /**
     * @api {post} /api/admin  建立新的管理员
     * @apiGroup admin
     * @apiParam {string} name 用户昵称
     * @apiParam {string} email 用户登陆名　email格式 必须唯一
     * @apiParam {string} password 用户登陆密码
     * @apiParam {string="admin","editor"} [role="editor"] 角色 内容为空或者其他的都设置为editor
     * @apiParam {string} [avatar] 用户头像地址
     * @apiParamExample {json} 请求的参数例子:
     *     {
     *       name: 'test',
     *       email: '1111@qq.com',
     *       password: '123456',
     *       role: 'editor',
     *       avatar: 'uploads/20178989.png'
     *     }
     *
     * @apiSuccessExample 新建用户成功
     * HTTP/1.1 201 OK
     * {
     * "status": "success",
     * "status_code": 201
     * }
     * @apiErrorExample 数据验证出错
     * HTTP/1.1 404 Not Found
     * {
     * "status": "error",
     * "status_code": 404,
     * "message": "信息提交不完全或者不规范，校验不通过，请重新提交"
     * }
     */
    public function store(Request $request)
    {
        //  新建管理员信息
       $all =$request->validate([
           'name'=>'required',
           'role' =>'nullable|string',
           'password' => 'required',
           'email' => 'required|email|unique:users',
           'avatar' => 'nullable|string']);
       // 对role进行特殊处理  role内容为空或者不为editor或者admin的话删除
       if (! $all['role']){
           $all = array_except($all,["role"]);
       } else {
           $role = $all['role'];
           if( ! in_array($role,$this->roles) ){
               $all = array_except($all,["role"]);
           }
       }
       $all['password'] = bcrypt($all['password']);
       if (User::create($all)) {
            return $this->success();
       }
    }


    /**
     * @api {get} /api/admin/:id 显示指定的管理员
     * @apiGroup admin
     *
     *
     * @apiSuccessExample 返回管理员信息
     * HTTP/1.1 200 OK
     * {
     * "data": {
     *   "id": 1,
     *   "name": "wmhello",
     *   "email": "871228582@qq.com",
     *   "role": "admin",
     *   "avatar": ""
     * },
     * "status": "success",
     * "status_code": 200
     * }
     *
     */
    public function show($id)
    {
        //
       $user =  User::find($id);
       return new \App\Http\Resources\User($user);
    }

    public function edit($id)
    {
        //
    }


    /**
     * @api {put} /api/admin/:id  更新指定的管理员
     * @apiGroup admin
     * @apiHeaderExample {json} http头部请求:
     *     {
     *       "content-type": "application/x-www-form-urlencoded"
     *     }
     * @apiParam {string} name 用户昵称
     * @apiParam {string="admin","editor"} [role=editor] 角色 内容为空或者其他的都设置为editor
     * @apiParam {string} [avatar] 用户头像地址
     * @apiParamExample {json} 请求参数例子
     *{
     *      name: 'test',
     *      role: 'editor',
     *      avatar: 'uploads/20174356.png'
     * }
     * @apiSuccessExample 返回密码设置成功的结果
     * HTTP/1.1 200 OK
     * {
     * "status": "success",
     * "status_code": 200
     * }
     * @apiErrorExample 数据验证出错
     * HTTP/1.1 404 Not Found
     * {
     * "status": "error",
     * "status_code": 404,
     * "message": "信息提交不完全或者不规范，校验不通过，请重新提交"
     * }
     */

    public function update(Request $request, $id)
    {

        $all = $request->validate([
            'name' => 'required|string',
            'role' => 'nullable|string',
            'avatar' =>'nullable|string'
        ]);

        // 对role进行特殊处理  role内容为空或者不为editor或者admin的话删除
        if (! $all['role']){
            $all = array_except($all,["role"]);
        } else {
            $role = $all['role'];
            if( ! in_array($role,$this->roles) ){
                $all = array_except($all,["role"]);
            }
        }

        $bool = User::where('id', $id)->update($all);

        if ($bool) {
            return $this->success();
        }
    }

    /**
     * @api {delete} /api/admin/:id  删除指定的管理员
     * @apiGroup admin
     *
     * @apiSuccessExample 用户删除成功
     * HTTP/1.1 200 OK
     * {
     * "status": "success",
     * "status_code": 200
     * }
     *
     * @apiErrorExample 用户删除失败
     * HTTP/1.1 404 ERROR
     * {
     * "status": "error",
     * "status_code": 404
     * }
     */

    public function destroy($id)
    {
        //
        $user = User::find($id);
        if ($user->delete()) {
            return $this->success();
        } else {
            return $this->error();
        }

    }

    /**
     * @api {post} /api/admin/:id/reset  重置指定管理员的密码
     * @apiGroup admin
     *
     * @apiParam {string} password 用户密码
     *
     * @apiSuccessExample 返回密码设置成功的结果
     * HTTP/1.1 200 OK
     * {
     * "status": "success",
     * "status_code": 200
     * }
     *
     */
    public function reset(Request $request, $id)
    {
        $password = $request->input('password');
        $user = User::find($id);
        $user->password = bcrypt($password);
        $user->save();
        return $this->success();
    }

    /**
     * @api {post} /api/admin/upload  头像图片上传
     * @apiGroup admin
     * @apiHeaderExample {json} http头部请求:
     *     {
     *       "content-type": "application/form-data"
     *     }
     *
     * @apiSuccessExample 上传成功
     * HTTP/1.1 200 OK
     * {
     * "status": "success",
     * "status_code": 200，
     * "data": {
     *   "url" : 'uploads/3201278123689.png'
     *  }
     * }
     *
     * @apiErrorExample 上传失败
     * HTTP/1.1 400 ERROR
     * {
     * "status": "error",
     * "status_code": 400
     * }
     */

    public function upload(Request $request)
    {
        if ($request->isMethod('POST')) {
//            var_dump($_FILES);
            $file = $request->file('photo');

            //判断文件是否上传成功
            if ($file->isValid()) {
                //获取原文件名
                $originalName = $file->getClientOriginalName();
                //扩展名
                $ext = $file->getClientOriginalExtension();
                //文件类型
                $type = $file->getClientMimeType();
                //临时绝对路径
                $realPath = $file->getRealPath();

                $filename = date('YmdHiS') . uniqid() . '.' . $ext;

                $bool = Storage::disk('uploads')->put($filename, file_get_contents($realPath));
                if ($bool) {
                    $filename = 'uploads/' . $filename;
                    return response()->json([
                        'status' => 'success',
                        'status_code' => 200,
                        'data' => [
                            'url' => $filename,
                        ]
                    ], 200);
                } else {
                    return $this->error();
                }
            }
        }
    }
}
