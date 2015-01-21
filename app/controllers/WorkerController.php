<?php

class WorkerController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /user
	 *
	 * @return Response
	 */
	public function index()
	{
		$worker = Worker::UserList()->paginate(20);
        return View::make('worker.index')->with(compact('worker'));
	}



	/**
	 * Show the form for creating a new resource.
	 * GET /user/create
	 *
	 * @return Response
	 */
	public function create()
	{
        $worker = new Worker();
        return View::make('worker.create')->with(compact('worker'));
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
            'password'              => 'required|alpha_num|between:4,8|confirmed',
            'password_confirmation' => 'required|alpha_num|between:4,8',
            'img'                   => 'max:1000',
            'email' => 'required|email|unique:users'
        );

        $validator = Validator::make(Input::all(), $rules);
        if ($validator->passes()) {
            $worker  = Worker::create(Input::all());
            $worker->password = Hash::make(Input::get('password'));
            $worker->save();

            if(Input::hasFile('img')){
                $path = base_path().'/support.web-kmv.ru/files/';
                $name = $filename = Str::random(20) . '.' . Input::file('img')->guessExtension();
                Input::file('img')->move($path,$name);
                $worker->img =$name;
                $worker->save();
            }
            return Redirect::route('worker.show',$worker->id)->with(compact('worker'));
        }else {
            return Redirect::route('worker.create')->withInput(Input::except('_token','password','password_confirmation','img'))->withErrors($validator);
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
        $worker = Worker::findOrFail($id);
        return View::make('worker.view')->with(compact('worker'));
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
        $worker = Worker::findOrFail($id);
		return View::make('worker.edit')->with(compact('worker'));
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
		$worker= Worker::findOrFail($id);
        $changes = array();

        $rules = array(
            'phone'                 => 'required|numeric',
            'img'                   => 'max:1000'
        );
        $email=Input::get('email',null);
        if($email!=$worker->email){
            $rules['email']= 'required|between:3,64|email|unique:users';
        }
        $password =Input::get('password',null);
        if( trim($password)!=''){
            $rules['password']= 'required|alpha_num|between:4,8|confirmed';
            $rules['password_confirmation']= 'required|alpha_num|between:4,8';
        }
        $validator = Validator::make(Input::all(), $rules);



        if ($validator->passes()) {

            if(Input::get('phone') && $worker->phone!==Input::get('phone')){
                $changes["phone"] = 'Телефон изменен, с '.$worker->phone.' на '.Input::get('phone');
                $worker->phone = Input::get('phone');
            }
            if(Input::get('email') && $worker->email!==Input::get('email')){

                $changes["email"] = 'Email изменен, с '.$worker->email.' на '.Input::get('email');
                $worker->email = Input::get('email');

            }
            if(Input::get('password') && Input::get('password_confirmation')){
                $changes["password"] = 'Пароль изменен';
                $worker->password =Hash::make(Input::get('password'));
                //возможна отправка на почту сообщения
            }
            if(!empty($changes)){
                 foreach($changes as $k=>$str){
                     Session::flash($k,$str);
                 }
            }else{
                Session::flash('error','Изменеий не внесено');
            }

            if(Input::hasFile('img')){
                $path = base_path().'/support.web-kmv.ru/files/';
                $name = $filename = Str::random(20) . '.' . Input::file('img')->guessExtension();
                Input::file('img')->move($path,$name);
                $worker->img =$name;
            }
            $worker->save();

            return Redirect::route('worker.show',$id)->with(compact('worker'));
        } else {
            return Redirect::route('worker.edit',$id)->withErrors($validator);
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
            Worker::find($id)->delete();
            return Redirect::route('worker.index');
        }

	}

}