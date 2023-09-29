<?php

namespace App\Http\Controllers\Authenticated\BulletinBoard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories\MainCategory;
use App\Models\Categories\SubCategory;
use App\Models\Posts\Post;
use App\Models\Posts\PostComment;
use App\Models\Posts\Like;
use App\Models\Users\User;
use App\Http\Requests\BulletinBoard\PostFormRequest;
use App\Http\Requests\BulletinBoard\PostUpdateFormRequest;
use App\Http\Requests\BulletinBoard\CommentFormRequest;
use App\Http\Requests\BulletinBoard\MainFormRequest;
use App\Http\Requests\MainFormRequest as RequestsMainFormRequest;
use Auth;

class PostsController extends Controller
{
    //掲示板を表示する
    public function show(Request $request){
        $posts = Post::with('user', 'postComments')->get();
        $categories = MainCategory::get();
        $like = new Like;
        $post_comment = new Post;
        if(!empty($request->keyword)){//キーワードがあった場合
            $posts = Post::with('user', 'postComments')
            ->where('post_title', 'like', '%'.$request->keyword.'%')
            ->orWhere('post', 'like', '%'.$request->keyword.'%')->get();

        }
            else if($request->category_word){//サブカテゴリーで検索の場合
                $sub_category = $request->category_word;
                $posts = Post::with('user', 'postComments')->get();
            }

                else if($request->like_posts){//いいねした投稿を取得する
                    $likes = Auth::user()->likePostId()->get('like_post_id');
                    //likePostId()で、ログインユーザーがいいねしているレコードをとってくる。
                    //そのレコードの,like_post_id（いいねした投稿のid）を取得する。

                    // dd($likes);
                    //like_post_id取得できている

                    $posts = Post::with('user', 'postComments')
                    ->whereIn('id', $likes)->get();
                    // dd($posts);
                    //いいねした投稿が全部取得できている
                }

                    else if($request->my_posts){//自分の投稿を検索する
                        $posts = Post::with('user', 'postComments')
                        ->where('user_id', Auth::id())->get();
                    }
        // dd($post_comment);
        //表示する
        return view('authenticated.bulletinboard.posts', compact('posts', 'categories', 'like', 'post_comment'));
    }

    //タイトルをクリックしたら投稿詳細画面へ遷移する処理
    public function postDetail($post_id){//投稿のidを受け取る

        $post = Post::with('user', 'postComments')->findOrFail($post_id);

        //Post.phpでリレーションしているメソッドを使う。user()とpostComments()、紐づいているuserテーブルとpostCommentsテーブルの、$post_idにはいっているid、と一致しているレコードを探す。一致したレコードを$postに入れる。

        // dd($post);

        return view('authenticated.bulletinboard.post_detail', compact('post'));
        //投稿詳細画面を表示する。$postを送る。
    }

    //新規投稿画面へ遷移する処理（投稿&カテゴリーの作成画面へ）
    public function postInput(){
        //メインカテゴリを取得する
        $main_categories = MainCategory::get();
        return view('authenticated.bulletinboard.post_create', compact('main_categories'));
    }

    //投稿内容の登録
    public function postCreate(PostFormRequest $request){//新規投稿用のバリデーション

        //投稿を登録
        $post = Post::create([
            'user_id' => Auth::id(),
            'post_title' => $request->post_title,
            'post' => $request->post_body,
            'created_at' => now(),
        ]);
        return redirect()->route('post.show');//掲示板へ
    }

    //モーダルで投稿を編集する処理
    public function postEdit(PostUpdateFormRequest $request){//投稿編集用のバリデーション
        Post::where('id', $request->post_id)->update([

            'post_title' => $request->post_title,//投稿タイトルを更新する処理
            'post' => $request->post_body,//投稿内容を更新する処理
            'created_at' => now(),
        ]);

        return redirect()->route('post.detail', ['id' => $request->post_id]);
            //更新したのち、投稿詳細画面へ遷移する処理

    }

    //投稿の削除
    public function postDelete($id){
        Post::findOrFail($id)->delete();
        return redirect()->route('post.show');
    }
    public function mainCategoryCreate(Request $request){
        MainCategory::create(['main_category' => $request->main_category_name]);
        return redirect()->route('post.input');
    }

    // コメントを登録する処理
    public function commentCreate(CommentFormRequest $request){

        PostComment::create([
            'post_id' => $request->post_id,//投稿のidを登録する。
            'user_id' => Auth::id(),//コメントを書いた人のid(ログインid)を登録する。
            'comment' => $request->comment//コメント本文を登録する。
        ]);

        return redirect()->route('post.detail', ['id' => $request->post_id]);
        //再度、投稿詳細画面へ遷移する処理。表示させるために、この投稿のidをまた送る。

    }

    public function myBulletinBoard(){
        $posts = Auth::user()->posts()->get();
        $like = new Like;
        return view('authenticated.bulletinboard.post_myself', compact('posts', 'like'));
    }

    public function likeBulletinBoard(){
        $like_post_id = Like::with('users')->where('like_user_id', Auth::id())->get('like_post_id')->toArray();
        $posts = Post::with('user')->whereIn('id', $like_post_id)->get();
        $like = new Like;
        return view('authenticated.bulletinboard.post_like', compact('posts', 'like'));
    }

    public function postLike(Request $request){
        $user_id = Auth::id();
        $post_id = $request->post_id;

        $like = new Like;

        $like->like_user_id = $user_id;
        $like->like_post_id = $post_id;
        $like->save();

        return response()->json();
    }

    public function postUnLike(Request $request)
    {
        $user_id = Auth::id();
        $post_id = $request->post_id;

        $like = new Like;

        $like->where('like_user_id', $user_id)
             ->where('like_post_id', $post_id)
             ->delete();

        return response()->json();
    }

    //メインカテゴリーを登録する処理
    public function mCategoryCreate(MainFormRequest $request)
    {
        //メインカテゴリーを登録
        MainCategory::create([
            'main_category' => $request->main_category_name,
            'created_at' => now(),
        ]);
        return redirect()->route('post.input'); //投稿画面へ戻る
    }

    //subCategoryを登録する処理subCategoryCreate
}
