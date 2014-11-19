<?php

class SearchController extends Controller{

    /**
     * Создание поискового индекса
     */
    public function getCreate()
    {
        App::abort('404','Page Not Found');
    }

    public  function getIndex(){
        $data = null;
        $q =Input::get('q',false);
        if($q){
            $qSQL = "%".$q."%";
            $data = Ticket::leftJoin('ticket_comments',function($join) use ($qSQL){
                $join->on('tickets.id','=','ticket_comments.ticket_id');
                $join->on('ticket_comments.comment','like',DB::raw('?'));
            })->whereRaw('title like ? or description like ? or url like ? or comment like ? ',array($qSQL,$qSQL,$qSQL,$qSQL,$qSQL))->select('tickets.id','title','description','url','comment')->paginate(20);
        }
        return View::make('search.index')->with(compact('q','data'));
    }
}