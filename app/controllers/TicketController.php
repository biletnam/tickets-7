<?php

class TicketController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('ticket/index');
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
		$ticket = Ticket::create(Input::all());
        if($ticket->validateCreate(Input::all())){
            $ticket->user_id = Auth::user()->id;
            $ticket->save();
            Session::flash('ticket.create','Задача создана, №'.$ticket->id);
            return Redirect::to('ticket');
        }else{
            return Redirect::to('ticket/create')->withErrors($ticket->errors())->withInput(Input::except('_token'));
        }

	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
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
