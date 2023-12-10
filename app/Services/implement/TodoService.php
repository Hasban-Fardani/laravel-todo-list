<?php

namespace App\Services\implement;

use App\Models\Todo;
use App\Models\User;
use App\Services\TodoServiceInterface;
use Illuminate\Http\Request;

Class TodoService
{
    public function save(Request $request)
    {
        Todo::create($request->only(['title', 'description']));   
    }

    public function getByUser(User $user)
    {
        return Todo::whereBelongsTo($user)->get();
    }

    public function update(array $data, Todo $todo){
        $todo->update($data);
    }
}