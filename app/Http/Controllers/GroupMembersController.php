<?php

namespace App\Http\Controllers;

use App\StudentGroup;
use Illuminate\Http\Request;

class GroupMembersController extends Controller
{
    public function addMember(Request $request, StudentGroup $group)
    {
        $request->validate([
                'user_id' => 'required'
        ]);
    }
}
