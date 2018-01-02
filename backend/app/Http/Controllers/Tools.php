<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/30 0030
 * Time: 22:57
 */

namespace App\Http\Controllers;

use App\Session;
use Carbon\Carbon;

trait Tools
{
   public function getCurrentSessionId(){
       $date = Carbon::now();
       $year = $date->year;
       $team = ($date->month>1 && $date->month<=7)?2:1;
       if ($date->month>=1 && $date->month<=7) {
           $year--;
       }
       $session_id = Session::where('year', $year) ->where('team', $team)->value('id');
       return $session_id;
   }
}