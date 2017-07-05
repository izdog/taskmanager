<?php

namespace App\Http\Controllers;

use App\Task;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        $tasks = DB::table('tasks')
            ->join('users', 'tasks.user_id', '=', 'users.id')
            ->select('tasks.*', 'users.name')
            ->orderBy('created_at')
            ->get();

        $tasksWithoutUser = DB::table('tasks')
            ->where('tasks.user_id', null)
            ->get();


        return Response::json(array('tasksWithUser' => $tasks, 'tasksWithoutUser' => $tasksWithoutUser, 'users' => $users));
    }

    public function tasksView(){
        return view('tasks');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
           'title' => 'required',
            'description' => 'required',
            'user_id' => 'required'
        ]);

//
        $task = Task::create($request->all());
        $task = Task::find($task->id);

        return Response::json($task);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::findOrFail($id);
        $users = User::all();

        return Response::json(array('task' => $task, 'users' => $users));
    }

    public function editView(){
        return view('editTaskView');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $task = Task::findOrFail($id);

        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'user_id' => 'required',
            'status' => 'required'
        ]);

        $task->update($request->all());

        return Response::json($task);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Task::destroy($id);

    }
}
