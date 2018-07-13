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

        $result = $group->join($user);

        switch ($result) {
            case 0:
                return response()->json(['success' => true, 'message' => 'You joined the group']);
                break;
            case 1:
                return response()->json(['success' => false, 'message' => 'You are not allowed to join in a group', 'code' => 1], 403);
                break;
            case 2:
                return response()->json(['success' => false, 'message' => 'This group is full', 'code' => 2], 400);
                break;
            case 3:
                return response()->json(['success' => false, 'message' => 'You are not enrolled this course', 'code' => 3], 403);
                break;
            case 4:
                return response()->json(['success' => false, 'message' => 'You are already on a group', 'code' => 4], 403);
                break;
        }

    }

    public function leave(Request $request, StudentGroup $group){

        if(auth()->user()->groups()->detach($group->id))
            return response()->json(['success' => true, 'message' => 'You leaved the group']);
        else
            return response()->json(['success' => false, 'message' => 'Group not found']);
    }
}
