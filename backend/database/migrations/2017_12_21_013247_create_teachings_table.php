<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeachingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teachings', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedSmallInteger('teacher_id')->comment('教师ID');
            $table->unsignedSmallInteger('session_id')->comment('学期ID');
            $table->unsignedTinyInteger('grade')->comment('年级 1、2、3');
            $table->string('class', '100')->comment('教学班级 书写方式1,2,3'); //代表教学班级为某个年级1、2、3班
            $table->unsignedTinyInteger('teach_id')->comment('教学科目');
            $table->unsignedTinyInteger('hour')->nullable()->comment('教学课时');
            $table->string('remark',50)->nullable()->comment('备注');
            $table->softDeletes();
            $table->timestamps();
            $table->comment = '分学期的教学信息表';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teachings');
    }
}
