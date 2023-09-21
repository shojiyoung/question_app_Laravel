<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<style>
    p {
        white-space: nowrap;
    }
    .todo-row {
        display: flex;
        align-items: center;
    }
    .todo-row p {
        margin: 0;
        padding: 5px;
    }

    .update-form__item-input{
    margin-top:30px;
    width:200%;
    height:200px;
    }

    .update-form__button-submit{
        margin:-50px 0 70px 200px;
    }

    .delete-form__button-submit{
        margin:195px 0 0px 40px;
    }

    .alert.alert-success {
        color: red;
    }

    .title{
        width:50%;
        font-size:16px;
        border: 2px solid blue;
    }

    .input{
        font-size:16px;
        width:50%;
        height:200px;
        border: 2px solid blue;
    }

    .title2{
        font-size:16px;
        width:210%;
    }

    .input2{
        font-size:16px;
        width:210%;
        height:200px;
    }
</style>
</head>
<body>
    @section('content')
    @if (Auth::check())
      <p>ログイン中ユーザー: {{ Auth::user()->name }}</p>
    @else
      <p>ログインしてください。（<a href="/login">ログイン</a>｜
      <a href="/register">登録</a>）</p>
    @endif

    <h1>相談窓口</h1>
    <form class="create-form" action="/todos" method="post">
        @csrf
        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
        <p>↓相談の内容を入力してください</p>
        <h4>タイトル</h4><input class="title" type="text" name="title">
        <h4>本文</h4><textarea class="input" type="text" name="content"></textarea>
        <button>投稿する</button>
   </form>

   @if(session('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
@endif


    @foreach($todos as $todo) <!-- 修正：$todos をループ -->
    <div class="todo-row">
        <form class="update-form" action="/todos/update" method="POST">
            @method('PATCH')
            @csrf
            <div class="update-form__item">
                <p>{{ $todo['id'] }}</p>
                <input class="title2" type="text" name="title" value="{{ $todo['title'] }}"><br>
                <textarea class="input2" type="text" name="content">{{ $todo['content'] }}</textarea>
                <p>投稿主: {{ $todo->user->name }}</p>
               
                <input type="hidden" name="id" value="{{ $todo['id'] }}">
            </div>
            
            

            <div class="update-form__button">
                <button class="update-form__button-submit" type="submit">更新</button>
            </div>
        </form>
        <form class="delete-form" action="/todos/delete" method="POST">
            @method('DELETE')
            @csrf
            <div class="delete-form__button">
                <input type="hidden" name="id" value="{{ $todo['id'] }}">
                <button class="delete-form__button-submit" type="submit">削除</button>
            </div>
        </form>
    </div>
    @foreach($todo->comments as $comment)
        <div class="comment">
            <p>ユーザー: {{ $comment->user->name }}</p>
            <p>{{ $comment->content }}</p>
        </div>
    @endforeach

    <form class="comment-form" action="/todos/{{ $todo->id }}/comments" method="POST">
        @csrf
        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
        <input type="text" name="content" placeholder="コメントを入力">
        <button type="submit">コメントする</button>
    </form>
    
    @endforeach <!-- ループ終了 -->
</body>
</html>