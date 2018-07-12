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

        return FullteachingClient::getUserCourses(auth()->user());
    }

    public function managers(Request $request, $course) {
        return GroupManager::all()->where('id_course', '=', $course);
    }
}
