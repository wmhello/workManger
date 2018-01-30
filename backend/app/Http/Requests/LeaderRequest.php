<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LeaderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'teacher_id' => "required|exists:yz_teacher,id",
            'leader_type' => "required|in:1,2",
            'job' => "nullable|string|max:20",
            'remark' => "nullable|string|max:50",
        ];
    }

    public function message()
    {
        return [
         'teacher_id.required' => '教师信息必须选择',
         'teacher_id.exists' => '所选择的教师信息不存在',
         'leader_type.required' => "行政类型必须填写",
        ];
    }
}
