<?php

namespace App\Http\Controllers;

use App\Interop\Fullteaching\FullteachingClient;
use App\StudentGroup;
use Illuminate\Http\Request;

class GroupMembersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function join(Request $request, StudentGroup $group)
    {
        $user = auth()->user();

        if(!$user->hasRole('student'))
            return response()->json(['success' => false, 'message' => 'You are not allowed to join in a group'], 403);

        if($group->max_members <= $group->members->count())
            return response()->json(['success' => false, 'message' => 'This group is full'], 400);

        if(!in_array($group->manager->id_course, array_column(FullteachingClient::getUserCourses(auth()->user()), 'id')))
            return response()->json(['success' => false, 'message' => 'You are not enrolled this course'], 403);


        $user->groups()->attach($group->id, ['group_manager_id' => $group->manager->id]);

        return response()->json(['success' => true, 'message' => 'You joined the group']);
    }

    public function leave(Request $request, StudentGroup $group){

        if(auth()->user()->groups()->detach($group->id))
            return response()->json(['success' => true, 'message' => 'You leaved the group']);
        else
            return response()->json(['success' => false, 'message' => 'Group not found']);
    }
}
