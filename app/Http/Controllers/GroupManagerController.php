<?php

namespace App\Http\Controllers;

use App\GroupManager;
use Illuminate\Http\Request;

class GroupManagerController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function groups(Request $request, GroupManager $manager) {
        return $manager->groups;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'id_course' => 'required|number',
        ]);

        if(!auth()->user()->hasRole('teacher'))
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);

       GroupManager::create([
          'name' => $request->get('owner'),
          'description' => $request->get('description'),
          'id_course' => $request->get('id_course'),
          'id_owner' => auth()->user()->id
       ]);

       return response()->json(['success' => true, 'message' => 'Group manager created with success']);
    }

    /**
     * Display the specified resource.
     *
     * @param GroupManager $manager
     * @return GroupManager
     */
    public function show(GroupManager $manager)
    {
        return $manager;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param GroupManager $manager
     * @return mixed
     */
    public function update(Request $request, GroupManager $manager)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required'
            ]);

        $manager->name = $request->get('name');
        $manager->description = $request->get('description');

        return response()->json(['success' => true, 'message' => 'Manager updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param GroupManager $manager
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(GroupManager $manager)
    {
        $manager->delete();
        return response()->json(['success' => true, 'Group manager deleted with success']);
    }
}
