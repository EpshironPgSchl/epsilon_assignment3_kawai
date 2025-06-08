<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PostController extends Controller
{
    use AuthorizesRequests;
    /**
     * 投稿の一覧を表示する
     */
    public function index()
    {
        //投稿を新しい順に10件ずつページネーションで取得
        $posts = Post::with('user')->latest()->paginate(10);

        // inertiaを使用して、'posts.index'ビューに投稿データを渡して表示
        return Inertia::render('Posts/Index', [
            'posts' => $posts,
        ]);
    }

    // /**
    //  * 新規投稿フォームを表示する
    //  */
    // public function create()
    // {
    //     // 'posts.create'ビューを表示
    //     return Inertia::render('Posts/Create', [
    //         'canCreate' => auth()->check(), // ログインしているかどうかをチェック
    //     ]);
    // }

    /**
     * 新規投稿をデータベースに保存する
     */
    public function store(Request $request)
    {
        //バリデーション
        $validated = $request->validate([
            'title' => 'required|string|max:50',
            'content' => 'required|string|max:2000',
        ], [
            'title.max' => 'タイトルは50文字以内で入力してください。',
            'title.required' => 'タイトルは必須です。',
            'content.required' => '本文は必須です。',
            'content.max' => '本文は2000文字以内で入力してください。',
        ]);

        // ログインしているユーザーのIDをマージして、投稿を作成
        $post = Post::create([
            'user_id' => auth()->id(), // ログインユーザーのID
            'title' => $validated['title'],
            'content' => $validated['content'],
        ]);

        // 投稿一覧ページにリダイレクトし、成功メッセージを表示
        return redirect()->route('posts.index')->with('success', '投稿しました。');
    }

    /**
     * 特定の投稿とコメントを表示する
     */
    public function show(Post $post)
    {
        // Eager loadingを使用して、関連するコメントとそのユーザを事前にロード
        $post->load('comments.user');
        // 'posts.show'ビューに投稿データを渡して表示
        return view('posts.show', compact('post'));
    }

    /**
     * 投稿編集フォームを表示する
     */
    public function edit(Post $post)
    {
        // 本人以外が編集できないようにする認可処理を入れるのが望ましい
        $this->authorize('update', $post); 

        // 'posts.edit' ビューに編集対象の投稿データを渡して表示
        return Inertia::render('Posts/Edit', [
            'post' => $post,
        ]);
    }

    /**
     * 投稿を更新する
     */
    public function update(Request $request, Post $post)
    {
        //認可処理
        $this->authorize('update', $post);

        //バリデーション
        $validated = $request->validate([
            'title' => 'required|string|max:50',
            'content' => 'required|string|max:2000',
        ], [
            'title.max' => 'タイトルは50文字以内で入力してください。',
            'title.required' => 'タイトルは必須です。',
            'content.required' => '本文は必須です。',
            'content.max' => '本文は2000文字以内で入力してください。',
        ]);

        // 投稿を更新
        $post->update($validated);

        // 投稿詳細ページにリダイレクトし、成功メッセージを表示
        return redirect()->route('posts.index', $post)->with('success', '投稿を更新しました。');
    }

    /**
     * 投稿を削除する
     */
    public function destroy(Post $post)
    {
        //認可処理
        $this->authorize('delete', $post);

        // 投稿を論理削除
        $post->delete();

        // 投稿一覧ページにリダイレクトし、成功メッセージを表示
        return redirect()->route('posts.index')->with('success', '投稿を削除しました。');
    }
}
