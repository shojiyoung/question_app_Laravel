<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;


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

    return redirect('/index')->with('message', 'Todoを更新しました');
}

public function destroy(Request $request)
{
    Comment::where('todo_id', $request->id)->delete();
    
    // Todo レコードを削除
    Todo::find($request->id)->delete();
    
    return redirect('/index')->with('message', 'Todoを削除しました');
}

public function login()
       {
        return view('login');
       }

       public function comment_store(Request $request, Todo $todo)
{
    $validatedData = $request->validate([
        'content' => 'required|string|max:255', // 必要に応じてバリデーションルールを変更
    ]);

    $comment = new Comment();
    $comment->user_id = Auth::user()->id;
    $comment->todo_id = $todo->id;
    $comment->content = $request->input('content');
    $comment->save();

    return redirect()->back()->with('success', 'コメントが投稿されました'); // 成功した場合のリダイレクト
}


}
