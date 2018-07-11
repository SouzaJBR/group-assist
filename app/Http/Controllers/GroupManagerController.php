<?php

namespace App\Http\Controllers;

use App\GroupManager;
use Illuminate\Http\Request;

class GroupManagerController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //TODO criar resource para ele
        return GroupManager::all();
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

       $manager = GroupManager::create([
          'name' => $request->get('owner'),
          'description' => $request->get('description'),
          'id_course' => $request->get('id_course'),
          'id_owner' => auth()->user()->id
       ]);

       return $manager;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(GroupManager $manager)
    {
        return $manager;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //TODO implementar função de atualização
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param GroupManager $manager
     * @return void
     */
    public function destroy(GroupManager $manager)
    {
        $manager->destroy();
    }
}
