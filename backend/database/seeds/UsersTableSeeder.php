<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
      DB::table('users')->insert([
          'name' => 'wmhello',
          'email' => '871228582@qq.com',
          'password' => bcrypt('514728'),
          'roles' => 'admin',
          'avatar' => '',
      ]);

        DB::table('users')->insert([
            'name' => 'dongdong',
            'email' => '786270744@qq.com',
            'password' => bcrypt('123456'),
            'roles' => 'editor',
            'avatar' => '',
        ]);
    }
}
