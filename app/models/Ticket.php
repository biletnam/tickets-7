<?php

class Ticket extends \Eloquent {
    protected $guarded = array('_token');

    public function scopeTicketList($query){
        if (Auth::user()->role!=="admin")
        {
            if(Auth::user()->role == 'worker') {
                $query->where('worker','LIKE','%['.Auth::user()->id.']%')->orWhere('user_id', '=', Auth::user()->id);
            } else {
                $query->where('user_id','=',Auth::user()->id);
            }
        }elseif(Auth::user()->role=="admin" && Input::get('user_id',false)){
            $query->where('user_id','=',Input::get('user_id'));
        } elseif(Auth::user()->role=="admin" && Input::get('user_id2',false)){
            $query->where('worker','LIKE','%['.Input::get('user_id2',false).']%');
        }
        if(Input::get('status_id') && is_numeric((int)Input::get('status_id'))){
            if(is_array(Input::get("status_id"))) $query->whereIn('status_id',Input::get('status_id'));
            else $query->where('status_id','=',Input::get('status_id'));
        }
        if(Input::get('id') && is_numeric((int)Input::get('id'))){
            if(is_array(Input::get("id"))) $query->whereIn('id',Input::get('id'));
            else $query->where('id','=',Input::get('id'));
        }

        if(Input::get('apply',false)!==false){
            $query->where('apply','=',Input::get('apply'));
        }

        if( Input::get('dt_from',false) && Input::get('dt_to',false)){
            $dt_from  = new DateTime(Input::get('dt_from'));
            $dt_to    = new DateTime(Input::get('dt_to'));
            $query->whereBetween('created_at',array($dt_from->format("Y-m-d 00:00:00"),$dt_to->format("Y-m-d 23:59:59")));
        }elseif(Input::get('dt_from',false) && !Input::get('dt_to',false)){
            $dt_from  = new DateTime(Input::get('dt_from'));
            $query->where('created_at','>=',$dt_from->format("Y-m-d 00:00:00"));
        }elseif(!Input::get('dt_from',false) && Input::get('dt_to',false)){
            $dt_to  = new DateTime(Input::get('dt_to'));
            $query->where('created_at','<=',$dt_to->format("Y-m-d 23:59:59"));
        }

        //$query->orderBy('created_at','desc');
         $query->orderBy('id','title');
    }

    public static  function statusCount($status_id){
        return Ticket::where('status_id','=',$status_id)->count();
    }

    public function user()
    {
        return $this->belongsTo('User')->select('full_name','email','img')->remember(10);
    }

    public function status()
    {
        return $this->belongsTo('Status')->select('title')->orderBy('order','asc');
    }

    public function priority()
    {
        return $this->belongsTo('Priority')->select('title')->orderBy('order','asc');
    }

    public function commets()
    {
        return $this->hasMany('TicketComment');
    }

}