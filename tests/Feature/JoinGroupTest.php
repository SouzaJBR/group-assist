<?php

namespace Tests\Feature;

use App\GroupManager;
use App\Interop\Fullteaching\FullteachingClient;
use App\StudentGroup;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class JoinGroupTest extends TestCase
{
    /**
     * Teste para criar
     *
     * @return void
     */
    public function testExample()
    {

        $userTeacher = FullteachingClient::login('teacher@gmail.com', 'pass');
        $userStudent = FullteachingClient::login('student1@gmail.com', 'pass');
        $userStudent2 = FullteachingClient::login('student1@gmail.com', 'pass');
        $courses = FullteachingClient::getUserCourses($userTeacher);

        $course = $courses[0];

        $manager = GroupManager::create([
            'id_owner' => $userTeacher->id,
            'id_course' => $course->id,
            'name' => 'teste',
            'description' => ''
        ]);

        $manager2 = GroupManager::create([
            'id_owner' => $userTeacher->id,
            'id_course' => 99999,
            'name' => 'teste',
            'description' => ''
        ]);

        $sg = StudentGroup::create([
            'group_manager_id' => $manager->id,
            'name' => 'test group',
            'description' => 'asd',
            'max_members' => 1,
            'user_id' => $userTeacher->id
        ]);

        $sg2 = StudentGroup::create([
            'group_manager_id' => $manager2->id,
            'name' => 'test group',
            'description' => 'asd',
            'max_members' => 1,
            'user_id' => $userTeacher->id
        ]);

        $this->assertEquals(0, $sg->join($userStudent));
        $this->assertEquals(1, $sg->join($userTeacher));
        $this->assertEquals(4, $sg->join($userStudent));
        $this->assertEquals(3, $sg2->join($userStudent));

        $sg->delete();
        $sg2->delete();
        $manager->delete();
        $manager2->delete();
    }
}
