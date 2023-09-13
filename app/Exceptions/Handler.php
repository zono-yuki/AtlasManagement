<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

use Illuminate\Session\TokenMismatchException;//419エラー対策
use Throwable;//419エラー対策

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Exception
     */
    // public function render($request, Exception $exception)
    // {
    //     return parent::render($request, $exception);
    // }

    public function render($request, Throwable $exception)
    //セッションタイムアウト後のログアウトで419エラーを出さないようにする
    {
        if ($exception instanceof
        TokenMismatchException) {
            // return redirect()->route('login');
            return redirect('/login');
            //ログイン画面へ遷移する
        }
        return parent::render($request, $exception);
    }

    // public function render($request, Exception $exception)
    // {
    //     // どの例外クラスが発生したかによって処理を分けられる。
    //     if($exception instanceof CustomException) {
    //         return '独自例外エラー発生！';
    //     }

    //     $class = get_class($exception);
    //     switch($class) {
    //         // 認証エラーの場合、どの認証に失敗したかによって、ログインURLを振り分ける
    //         case 'Illuminate\Auth\AuthenticationException':
    //             $guard = array_get($exception->guards(), 0);
    //             switch ($guard) {
    //                 case 'user':
    //                     $login = 'section/login';
    //                     break;
    //                 case 'admin':
    //                     $login = 'admin/login';
    //                     break;
    //                 default:
    //                     $login = 'login';
    //                     break;
    //             }
    //             return redirect($login);

    //         // formで2時間以上放置するとxsrfトークンの有効期限が切れてエラー画面になる
    //         // The page has expired due to inactivity.Please refresh and try againと表示させずに、元の画面にリダイレクトする。
    //         // redirectなので、xsrfトークンが再発行され、送信ボタンを押せば問題なく送信されるはず
    //         case 'Illuminate\Session\TokenMismatchException':
    //             return back()->withInput();
    //     }
    //     // それ以外のエラーは、そのまま画面に表示
    //     return parent::render($request, $exception);
    // }
}
