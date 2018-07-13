<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class JoinGroupTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function joinGroup()
    {

        $userTeacher = FullteachingClient::login('teacher@gmail.com', 'pass');
        $userStudent = FullteachingClient::login('student1@gmail.com', 'pass');
        $courses = FullteachingClient::getUserCourses($userTeacher);

        $course = $courses[0];

        $manager = GroupManager::create([
            'id_owner' => $userTeacher->id,
            'id_course' => $course->id,
            'name' => 'teste',
            'description' => ''
        ]);

        $sg = StudentGroup::create([
            'group_manager_id' => $manager->id,
            'name' => 'test group',
            'description' => 'asd',
            'max_students' => 5,
            'user_id' => $userTeacher->id
        ]);

        $this->assertTrue($userStudent->hasRole('student'));
        $this->assertTrue($userTeacher->hasRole('teacher'));

        $userStudent->groups()->attach($sg->id, ['group_manager_id' => $manager->id]);
    }
}
