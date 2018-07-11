<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{
    Http\Resources\StudentGroupResource, StudentGroup
};

class StudentGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth:api')->except(['index', 'show']);
    }

    public function index()
    {
        return StudentGroupResource::collection(StudentGroup::paginate(25));
    }

    public function getGroupsByManager(Request $request, $id) {

        return StudentGroupResource::collection(StudentGroup::all()->where('group_manager_id', '=', $id));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string',
            'description' => 'required',
            'max_students' => 'required|integer'
        ]);

        $studentGroup = StudentGroup::create([
            'user_id' => auth()->user()->id,
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'max_students' => $request->get('max_students')
        ]);

        return new StudentGroupResource($studentGroup);
    }

    /**
     * Display the specified resource.
     *
     * @param StudentGroup $group
     * @return StudentGroupResource
     */
    public function show(StudentGroup $group)
    {
        return new StudentGroupResource($group);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StudentGroup $group)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required',
            'max_students' => 'required|integer'
        ]);

        $group->name = $request->get('name');
        $group->description = $request->get('description');
        $group->max_students = $request->get('max_students');

        $group->save();

        return response()->json(['success' => true, 'message' => 'Dados atualizados com sucesso']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param StudentGroup $studentGroup
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(StudentGroup $studentGroup)
    {
        $studentGroup->delete();

        return response()->json(['success' => true, 'message' => 'Dado removido com sucesso'], 204);
    }
    
}
