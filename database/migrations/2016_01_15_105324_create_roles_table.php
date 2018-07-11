<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use jeremykenedy\LaravelRoles\Models\Role;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('description')->nullable();
            $table->integer('level')->default(1);
            $table->timestamps();
        });

        Role::create([
            'name' => 'Teacher',
            'slug' => 'teacher',
            'description' => 'Teacher Role',
            'level' => 5,
        ]);

        Role::create([
            'name' => 'Student',
            'slug' => 'Student',
            'description' => 'Student Role',
            'level' => 1,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}