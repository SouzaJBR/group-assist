<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentGroupUserPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_group_user', function (Blueprint $table) {
            $table->integer('student_group_id')->unsigned();
            $table->foreign('student_group_id')->references('id')->on('student_groups')->onDelete('cascade');
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('group_manager_id')->unsigned()->index();
            $table->foreign('group_manager_id')->references('id')->on('group_managers')->onDelete('cascade');
            $table->primary(['group_manager_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('student_group_user');
    }
}
