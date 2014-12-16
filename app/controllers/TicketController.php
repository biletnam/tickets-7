<?php

class TicketController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $tickets = Ticket::TicketList()->paginate(20);
        $statusCollection  = Status::orderBy("order")->get(array('id','title'));
        $status = array();
        foreach($statusCollection as $stat){
            $status[$stat["id"]]=$stat["title"];
        }
        if(Input::get('status')){
            $tickets->appends(array('status'=>Input::get('status')));
        }
       // echo "<pre>";
        //print_r($tickets);
        if (Auth::user()->role!=="admin")
        {
            return View::make('ticket/index')->with(compact('tickets','status'));
        }else
        {
            $countNew  = Ticket::statusCount(1);
            $countWork = Ticket::statusCount(2);
            return View::make('ticket/index_admin')->with(compact('tickets','status','countNew','countWork'));
        }


	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{

        $ticket = new Ticket;
        $priorities  = Priority::arrayPriority();

        return View::make('ticket/create')->with(compact('priorities','ticket'));
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        $validate = Validator::make(Input::all(),['url'=>'required',
                                'title'=>'required',
                                'priority_id'=>'required',
                                'file_path'=>'max:8000'
                            ]);

        if(!$validate->fails()){
            $ticket = Ticket::create(Input::all());
            //echo "<pre>";
            //print_r($ticket);
            //exit;
            //$ticket->user_id = Auth::user()->id;
            if ($ticket->save()){
                if(Input::hasFile('file_path')){
                    $path = base_path().'/support.web-kmv.ru/files/';
                    $name = $filename = Str::random(20) . '.' . Input::file('file_path')->guessExtension();
                    Input::file('file_path')->move($path,$name);
                    $ticket->file_path =$path.$name;
                    $ticket->save();
                }
                if(Input::hasFile('file_path2')){
                    $path2 = base_path().'/support.web-kmv.ru/files/';
                    $name2 = $filename = Str::random(20) . '.' . Input::file('file_path2')->guessExtension();
                    Input::file('file_path2')->move($path2,$name2);
                    $ticket->file_path2 =$path2.$name2;
                    $ticket->save();
                }
                if(Input::hasFile('file_path2')){
                    $path3 = base_path().'/support.web-kmv.ru/files/';
                    $name3 = $filename = Str::random(20) . '.' . Input::file('file_path3')->guessExtension();
                    Input::file('file_path3')->move($path3,$name3);
                    $ticket->file_path3 =$path3.$name3;
                    $ticket->save();
                }
                Session::flash('ticket.create','Задача создана, №'.$ticket->id);
                return Redirect::to('ticket');
            }
        }else{
            return Redirect::to('ticket/create')->withInput(Input::except('_token','file_path'))->withErrors($validate->errors());
        }

	}


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @throws
     * @return Response
     */
	public function show($id)
	{
        $ticket= Ticket::findOrFail($id);
        //echo "<pre>";
        //print_r($ticket['original']['worker']);
        if($ticket->user_id==Auth::user()->id || Auth::user()->role=="admin" || preg_match('['.Auth::user()->id.']',$ticket['original']['worker'])){
            return View::make('ticket.view')->with(compact('ticket'));
        }else{
            App::abort(403, 'У вас нет прав, для просмотра этой страницы.');
        }

	}


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @throws Exception
     * @return Response
     */
	public function edit($id)
	{
        $ticket= Ticket::findOrFail($id);
        $status_obj = Status::orderBy('order')->get();
        $statuses = array();
        foreach($status_obj as $status){
            $statuses[$status->id]=$status->title;
        }
        $users_me = array();
        $user_list = User::orderBy('id', 'desc')->get();
        foreach($user_list as $key => $user_l){
            if($user_l->role == 'worker' || $user_l->role == 'admin' ) {
                $users_me[$user_l->id]=$user_l->full_name;
            }
        }
        $work = array();

        if($ticket->user_id==Auth::user()->id || Auth::user()->role=="admin"){
            if (Auth::user()->role!=="admin"){
                return View::make('ticket.edit')->with(compact('ticket','statuses','users_me'));
            }else{
                return View::make('ticket.edit')->with(compact('ticket','statuses','users_me'));
            }
        }else{
            App::abort(403, 'У вас нет прав, для просмотра этой страницы.');
        }
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
        $ticket= Ticket::findOrFail($id);
        if($ticket->user_id==Auth::user()->id || Auth::user()->role=="admin"){
            $change  = array();
            if(Input::get("status_id") && $ticket->status_id !=Input::get("status_id") && Auth::user()->role=='admin'){
                $ticket->status_id = Input::get("status_id");
                $change = array('status_id'=>'Статус задачи изменен');
            }

            if(Input::get("price") && $ticket->price !=Input::get("price") && Auth::user()->role=='admin'){
                $ticket->price = Input::get("price");
                $change = array('status_id'=>'Стоимость выполнения задачи изменена');
            }
            if(Input::get("worker") && $ticket->worker !=Input::get("worker") && Auth::user()->role=='admin'){
                $comma_separated = '['.implode("],[", Input::get("worker")).']';
                $ticket->worker = $comma_separated;
            }
            if(Input::get("time_real") && $ticket->time_real !=Input::get("time_real") && Auth::user()->role=='admin'){
                $ticket->time_real = Input::get("time_real");
            }
            if(Input::get("time_expected") && $ticket->time_expected !=Input::get("time_expected") && Auth::user()->role=='admin'){
                $ticket->time_expected = Input::get("time_expected");
            }
            //echo "<pre>";
            //print_r(Input::get("worker"));
            //exit;

            // идет проверка установлен ли Cтатус подтверждения заказчиком
            if(Input::get("apply") && $ticket->price !=Input::get("apply")){

            }
            $ticket->apply = Input::get("apply");
            $change = array('status_id'=>'Подтверждено.');
            if(!empty($change) && $ticket->save()){
                if(Input::get("save_new")) {
                    header("Location: /ticket/?mes=Сохранено.");exit;
                }
                foreach($change as $k=>$str){
                    Session::flash($k,$str);
                }
                if(Auth::user()->role=="admin"){
                    return Redirect::route('ticket.edit',array($id));
                }else{
                    return Redirect::route('ticket.show',array($id));
                }
            }else{
                if(empty($change)){
                    Session::flash('error','Вы не внесли изменения в задачу');
                }
                if(Auth::user()->role=="admin"){
                    return Redirect::route('ticket.edit',array($id));
                }else{
                    return Redirect::route('ticket.show',array($id));
                }

            }
        }else{
            App::abort(403, 'У вас нет прав, для просмотра этой страницы.');
        }
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
