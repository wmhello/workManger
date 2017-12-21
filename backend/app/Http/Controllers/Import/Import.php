<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/21 0021
 * Time: 15:14
 */

namespace App\Http\Controllers\Import;

Interface Import
{
    public function importData($file);
}