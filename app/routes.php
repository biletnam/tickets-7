<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

/**
 * Main page
 */
Route::get('/',['as'=>'home',
        function(){
            if(Auth::check()){
                return Redirect::to('ticket');
            }else{
                return View::make('home');
            }
        }]);

Route::get('/login',function(){
    return View::make('home');
    });



/**
 * Authentificate
 */
Route::post('/login',array('as'=>'login',function()
    {

        $email = Input::get('email');
        $password = Input::get('password');

        if (Auth::attempt(array('email' => $email, 'password' => $password),true)) {

            return Redirect::to('/')->with('success', 'You have been logged in');
        }
        else {
            return Redirect::to('/')->withErrors(array('login'=>'Логин или пароль введен не верно.'));
        }
        return View::make('/');
    }));


/**
 * Logout
 */
Route::get('/logout',array('as'=>'logout',function() {
        Auth::logout();
        return Redirect::to('/')->with('success', 'You have successfully logged out');
    }));



/**
 * Пути доступные после регистрации
 */
Route::group(array('before' => 'auth'),function(){
        Route::resource('ticket','TicketController');

        Route::post('/comment/',array('as'=>'commenet',function(){
            $ticket_id = Input::get('ticket_id');
            $comment = Input::get('comment');
            if(!empty($ticket_id) && !empty($comment)){
                $ticketComment = new TicketComment;
                $ticketComment->ticket_id = $ticket_id;
                $ticketComment->user_id =  Auth::user()->id;
                $ticketComment->comment = addslashes(htmlspecialchars(strip_tags($comment)));
                $dt = new DateTime();
                $ticketComment->created_at = $dt->format('Y-m-d H:i:s');
                echo json_encode($ticketComment);
                if ($ticketComment->save()){
                    Response::make(json_encode($ticketComment));
                }else{

                }
            }
        }));



        Route::controller('search','SearchController');
        /**
         *  Вытащить файл
         */
        Route::get('manager/{ticket}',['as'=>'manager',
            function($id){
            if(!empty($id)){
                $ticket = Ticket::findOrFail($id);
                if(Auth::user()->role != 'admin' || Auth::user()->id != $ticket->user_id){
                    return Response::download($ticket->file_path);
                }else{
                    App::abort('403','Acceess denied');
                }
            }
        }]);
    });

/**
 * Пути доступные только админам
 */
Route::group(array('before' => array('auth','admin')),function(){
    Route::resource('user','UserController');
});
Route::group(array('before' => array('auth','admin')),function(){
    Route::resource('worker','WorkerController');
});
Route::get('base/homepagesend/','BaseController@homepagesend');