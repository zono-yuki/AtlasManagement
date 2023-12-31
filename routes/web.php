<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['guest']], function(){
    Route::namespace('Auth')->group(function(){

        //新規登録画面を表示する
        Route::get('/register', 'RegisterController@registerView')->name('registerView');

        //新規登録ボタンを押した時の登録処理へ
        Route::post('/register/post', 'RegisterController@registerPost')->name('registerPost');

        //ログイン画面を表示する
        Route::get('/login', 'LoginController@loginView')->name('loginView');

        //ログインボタンを押した時の処理
        Route::post('/login/post', 'LoginController@loginPost')->name('loginPost');
    });
});

Route::group(['middleware' => 'auth'], function(){
    Route::namespace('Authenticated')->group(function(){

        Route::namespace('Top')->group(function(){

            //ログアウトする処理
            Route::get('/logout', 'TopsController@logout');

            //トップ画面を表示する処理
            Route::get('/top', 'TopsController@show')->name('top.show');
        });

    //--------スクール予約機能エリア--------------------------------------------------------

        Route::namespace('Calendar')->group(function(){
            //生徒&教師
            Route::namespace('General')->group(function(){

                //スクール予約画面を表示
                Route::get('/calendar/{user_id}', 'CalendarsController@show')->name('calendar.general.show');

                //予約するボタンを押した時
                Route::post('/reserve/calendar', 'CalendarsController@reserve')->name('reserveParts');

                //キャンセルボタンを押した時
                Route::post('/delete/calendar', 'CalendarsController@delete')->name('deleteParts');
            });

            //教師
            Route::namespace('Admin')->group(function(){

                //予約確認画面を表示(人数を表示する)
                Route::get('/calendar/{user_id}/admin', 'CalendarsController@show')->name('calendar.admin.show');

                //スクール予約詳細画面を表示する
                Route::get('/calendar/{date}/{part}', 'CalendarsController@reserveDetail')->name('calendar.admin.detail');

                //スクール枠登録画面を表示
                Route::get('/setting/{user_id}/admin', 'CalendarsController@reserveSettings')->name('calendar.admin.setting');

                //登録ボタンを押した時
                Route::post('/setting/update/admin', 'CalendarsController@updateSettings')->name('calendar.admin.update');
            });
        });


    //------------------掲示板エリア-----------------------------------------------------

        Route::namespace('BulletinBoard')->group(function(){

            //掲示板へ
            Route::get('/bulletin_board/posts/{keyword?}', 'PostsController@show')->name('post.show');
            //掲示板へ(試験的に)
            Route::post('/bulletin_board/posts/{category_word?}', 'PostsController@show')->name('post.show');

            //投稿画面へ
            Route::get('/bulletin_board/input', 'PostsController@postInput')->name('post.input');

            Route::get('/bulletin_board/like', 'PostsController@likeBulletinBoard')->name('like.bulletin.board');

            Route::get('/bulletin_board/my_post', 'PostsController@myBulletinBoard')->name('my.bulletin.board');

            //新規投稿
            Route::post('/bulletin_board/create', 'PostsController@postCreate')->name('post.create');


            //メインカテゴリーを追加する
            Route::post('/create/main_category', 'PostsController@mCategoryCreate')->name('main.category.create');

            //サブカテゴリーを追加する
            Route::post('/create/sub_category', 'PostsController@subCategoryCreate')->name('sub.category.create');


            //投稿詳細画面へ遷移する
            Route::get('/bulletin_board/post/{id}', 'PostsController@postDetail')->name('post.detail');

            //編集モーダルで、編集ボタンを押したら、
            Route::post('/bulletin_board/edit', 'PostsController@postEdit')->name('post.edit');

            //投稿削除
            Route::get('/bulletin_board/delete/{id}', 'PostsController@postDelete')->name('post.delete');

            //コメントをpost_commentsテーブルに登録する処理
            Route::post('/comment/create', 'PostsController@commentCreate')->name('comment.create');

            //いいね
            Route::post('/like/post/{id}', 'PostsController@postLike')->name('post.like');

            //いいね消す
            Route::post('/unlike/post/{id}', 'PostsController@postUnLike')->name('post.unlike');

        });
        Route::namespace('Users')->group(function(){

            //検索してユーザー検索画面を表示する
            Route::get('/show/users', 'UsersController@showUsers')->name('user.show');

            //プロフィール画面を表示する
            Route::get('/user/profile/{id}', 'UsersController@userProfile')->name('user.profile');

            Route::post('/user/profile/edit', 'UsersController@userEdit')->name('user.edit');
        });
    });
});
