<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $todos = auth()->check() ? Todo::where('user_id', auth()->user()->id)->get() : [];
        return view('index', compact('todos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);
        
        // save todo
        $todo = new Todo();
        $todo->title = $request->title;
        $todo->description = $request->description;
        $todo->user_id = auth()->user()->id;
        $todo->save();

        // redirect to / with success message
        return redirect('/')->with('success', 'Todo added successfully');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // validate request
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);
        
        // update todo
        $todo = Todo::find($request->id);
        $todo->title = $request->title;
        $todo->description = $request->description;
        $todo->user_id = auth()->user()->id;
        $todo->update();

        // redirect to / with success message
        return redirect('/')->with('success', 'Todo updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Todo $todo)
    {
        // delete todo
        $todo->delete();

        // redirect to / with success message
        return redirect('/')->with('success', 'Todo deleted successfully');
    }
}
