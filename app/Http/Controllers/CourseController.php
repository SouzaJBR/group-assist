<?php

namespace App\Http\Controllers;

use App\GroupManager;
use App\Interop\Fullteaching\FullteachingClient;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index() {
        //TODO criar recurso para esse cara aqui
        $courses = FullteachingClient::getUserCourses(auth()->user());

        $response = array();

        foreach ($courses as $course) {
            $response[] = (object) [
                'id' => $course->id,
                'title' => $course->title,
                'image' => $course->image
            ];
        }
        return $response;
    }

    public function managers(Request $request, $course) {
        return GroupManager::all()->where('id_course', '=', $course);
    }
}
