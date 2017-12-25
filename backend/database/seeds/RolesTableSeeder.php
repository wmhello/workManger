<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
       DB::table('roles')->insert([
           'name' => 'admin',
           'explain' => '管理员',
           'created_at' => Carbon::now(),
           'updated_at' => Carbon::now()

       ]);
        DB::table('roles')->insert([
        'name' => 'user',
        'explain' => '用户',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
        ]);
        DB::table('roles')->insert([
            'name' => 'teacher',
            'explain' => '教师',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        DB::table('roles')->insert([
            'name' => 'office',
            'explain' => '办公管理人员',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        DB::table('roles')->insert([
            'name' => 'finance',
            'explain' => '财务人员',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
