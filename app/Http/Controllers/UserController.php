<?php

namespace App\Http\Controllers;

use App\Task;
use App\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        var_dump($request->>)
        $this->validate($request, [
            'name' => 'required|min:3',
            'email' => 'required|unique:users'
        ]);

        $user = User::create($request->all());

        return Response::json($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    
    public function show()
    {
        return view('userTasks');
    }

    public function editView(){
        return view('editUserView');
    }
    public function getTasksByUserId($id){
        $user = User::findOrFail($id);
        $tasks = User::findOrFail($id)->tasks;

        return Response::json(array('user' => $user, 'tasks' => $tasks));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrfail($id);

        return Response::json($user);
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
        $user = User::findOrFail($id);

        $this->validate($request, [
            'name' => 'required|min:3',
            'email' => 'required'
        ]);


        if($request->name == $user->name && $request->email == $user->email):
            $msg['error'] = 'Data didn\'t change';
            return Response::json($msg);
        endif;

        if($request->name != $user->name):
            $user->name = $request->name;
            $user->save();
        endif;

        if($request->email != $user->email):
            $this->validate($request, [
               'email' => 'unique:users'
            ]);
            $user->email = $request->email;
            $user->save();
        endif;


        return Response::json($user);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tasks = Task::where('user_id', $id)->get();

        for ($i = 0; $i < count($tasks); $i++){
            $task = Task::find($tasks[$i]['id']);

            $task->user_id = null;
            $task->save();
        }

        User::destroy($id);

    }
}
