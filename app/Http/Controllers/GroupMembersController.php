<?php

namespace App\Http\Controllers;

use App\StudentGroup;
use Illuminate\Http\Request;

class GroupMembersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function join(Request $request)
    {

        $request->validate([
           'group' => 'required|exists:student_groups'
        ]);

        $group = StudentGroup::find($request->get('group'));

        //TODO validar se o usuário não está em um grupo
        //TODO validar se o usuário possui permissão para ingressar
        //TODO validar se o grupo não excede o máximo de integrantes

        $user = auth()->user();
        $user->groups()->attach($group->id);
    }

    public function leave(Request $request){
        $request->validate([
            'group' => 'required|exists:student_groups'
        ]);

        if(auth()->user()->groups()->detach($request->get('group')))
            return response()->json(['success' => true, 'message' => 'You leaved the group']);
        else
            return response()->json(['success' => false, 'message' => 'Group not found']);
    }
}
