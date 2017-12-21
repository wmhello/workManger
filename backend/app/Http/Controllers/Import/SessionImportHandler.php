<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/21 0021
 * Time: 18:05
 */

namespace App\Http\Controllers\Import;

use App\Session;

class SessionImportHandler implements \Maatwebsite\Excel\Files\ImportHandler
{
    public function handle($file)
    {
        // get the results
        // 获取第一个工作表电子表格的数据
        $results = $file->first()->toArray();
        $lists = [];
        foreach ($results as $v){
            $data = [
               'year' => (int)$v[0],
               'team' =>(int)$v[1],
               'remark' =>$v[2]
            ];
           if (Session::where('year', $data['year'])->where('team', $data['team'])->first()){  // 存在重复记录
               continue;
           } else { // 记录先暂时保存到数组，稍后一次新建
               array_push($lists,$data);
           }
        }
        return Session::insert($lists);
    }

}