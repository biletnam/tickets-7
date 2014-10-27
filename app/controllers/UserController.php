<?php

class UserController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /user
	 *
	 * @return Response
	 */
	public function index()
	{
		$users = User::UserList()->paginate(20);
        return View::make('user.index')->with(compact('users'));
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /user/create
	 *
	 * @return Response
	 */
	public function create()
	{
        $user = new User();
        return View::make('user.create')->with(compact('user'));
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /user
	 *
	 * @return Response
	 */
	public function store()
	{

        $rules = array(
            'full_name'             => 'required',
            'role'                  => 'required',
            'phone'                 => 'required|numeric',
            'email'                 => 'required|between:3,64|email|unique:users',
            'password'              => 'required|alpha_num|between:4,8|confirmed',
            'password_confirmation' => 'required|alpha_num|between:4,8'
        );

        $validator = Validator::make(Input::all(), $rules);
        if ($validator->passes()) {
            $user  = User::create(Input::all());
            $user->password = Hash::make(Input::get('password'));
            $user->save();

            return Redirect::route('user.show',$user->id)->with(compact('user'));
        } else {
            return Redirect::route('user.create')->withInput(Input::except('_token','password','password_confirmation'))->withErrors($validator);
        }
	}

	/**
	 * Display the specified resource.
	 * GET /user/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $user = User::findOrFail($id);
        return View::make('user.view')->with(compact('user'));
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /user/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $user = User::findOrFail($id);
		return View::make('user.edit')->with(compact('user'));
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /user/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$user= User::findOrFail($id);
        $changes = array();

        $rules = array(
            'phone'                 => 'required|numeric',
            'email'                 => 'required|between:3,64|email|unique:users',
            'password'              => 'required|alpha_num|between:4,8|confirmed',
            'password_confirmation' => 'required|alpha_num|between:4,8'
        );

        $validator = Validator::make(Input::all(), $rules);



        if ($validator->passes()) {

            if(Input::get('phone') && $user->phone!==Input::get('phone')){
                $changes["phone"] = 'Телефон изменен, с '.$user->phone.' на '.Input::get('phone');
                $user->phone = Input::get('phone');
            }
            if(Input::get('email') && $user->email!==Input::get('email')){

                $changes["email"] = 'Email изменен, с '.$user->email.' на '.Input::get('email');
                $user->email = Input::get('email');

            }
            if(Input::get('password') && Input::get('password_confirmation')){
                $changes["password"] = 'Пароль изменен';
                $user->password =Hash::make(Input::get('password'));
                //возможна отправка на почту сообщения
            }
            if(!empty($changes)){
                 foreach($changes as $k=>$str){
                     Session::flash($k,$str);
                 }
            }else{
                Session::flash('error','Изменеий не внесено');
            }
            $user->save();
            return Redirect::route('user.show',$id)->with(compact('user'));
        } else {
            return Redirect::route('user.edit',$id)->withErrors($validator);
        }
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /user/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{

        if($id == 1){
            App::abort('500','Не возможно удалить первого пользователя');
        }else{
            User::find($id)->delete();
            return Redirect::route('user.index');
        }

	}

}