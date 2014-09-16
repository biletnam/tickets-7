<?php

class SearchController extends Controller{

    /**
     * Создание поискового индекса
     */
    public function getCreate()
    {
        Search::index('user')->deleteIndex();

        $dbResult = DB::table('users')->join('tickets',function($join){
            $join->on('users.id',"=",'tickets.user_id');
        });
        if(Auth::user()->role!='admin'){
            $dbResult->where('users.id','=',Auth::user()->id);
        }
        $dbResult = $dbResult->get(array('users.id as user_id','full_name as fio','phone','tickets.id as ticket_id','email','url','title','description'));

        foreach($dbResult as $row){
            Search::index('user')->insert($row->ticket_id,[
                'fio'=>$row->fio,
                'phone'=>$row->phone,
                'email'=>$row->email,
                'ticket_id'=>$row->ticket_id,
                'title'=>$row->title,
                'description'=>$row->description,
                'url'=>$row->url
            ],['user_id'=>intval($row->user_id),'ticket_id'=>intval($row->ticket_id)]);
        }
        return 1;
    }

    public  function getIndex(){
        $q = Input::get('q');
        $dbResult = Search::index('user')->search(array('email','phone','fio','title','description','url'), $q)->get();
        return View::make('search/index')->with(compact('q','dbResult'));
    }
}