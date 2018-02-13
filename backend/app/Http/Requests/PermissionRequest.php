<?php

namespace App\Http\Requests;


class PermissionRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'pid' => 'required|integer',
            'type' => 'required|in:1,2',
            'method' => 'required|string',
            'route_name' => 'required|string',
        ];
//        switch ($this->method())
//        {
//            case 'POST':
//                return [
//                     'name' => 'required|string|unique',
//                     'pid' => 'required|integer',
//                     'type' => 'required|in:1,2',
//                    'method' => 'required_if:type,2|string',
//                     'route_name' => 'required_if:type,2|string|unique',
//                ];
//                break;
//            case 'PUT':
//            case 'PATCH':
//                return [
//                    'name' => 'required|string|unique:permissions,route_name,'.$this->id,
//                    'pid' => 'required|integer',
//                    'type' => 'required|in:1,2',
//                    'method' => 'required_if:type,2|string',
//                    'route_name' => 'required_if:type,2|unique:permissions,route_name,'.$this->id.'|string',
//                ];
//                break;
//            default:
//            {
//                return [];
//            }
//        }
    }

    public function messages()
    {
        return [
            'name.required' => '功能名称必须填写',
            'pid.required' =>  '所属组称必须填写',
            'type.required' => '功能类型必须填写',
            'route_name.required_if' => '路由名称必须填写',
            'route_name.unique' => '路由名称已经存在，不能重复出现',
            'method.required_if' => '访问方法必须填写',
        ];
    }
}
