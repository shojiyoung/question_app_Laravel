<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use App\Models\Comment;

class TestController extends Controller
{
    public function index()
       {
        $todos = Todo::with('comments')->get();
        $comments = Comment::all();
        return view('index', compact('todos', 'comments'));
       }

       public function store(Request $request)
       {
        $todos = Todo::all();
        $todoData = $request->only(['title', 'content','user_id']); 
        Todo::create($todoData);                     # データベースにデータを追加する記述
        return redirect('/index');
       }
       

       public function update(Request $request)
{
    $todo = $request->only(['title', 'content']); 
    Todo::find($request->id)->update($todo);

    return redirect('/')->with('message', 'Todoを更新しました');
}

public function destroy(Request $request)
{
    Todo::find($request->id)->delete();
    return redirect('/')->with('message', 'Todoを削除しました');
}

public function login()
       {
        return view('login');
       }
}
