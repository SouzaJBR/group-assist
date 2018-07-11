<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function managers(Request $request, $course) {
        return GroupManager::all()->where('id_course', '=', $course);
    }
}
