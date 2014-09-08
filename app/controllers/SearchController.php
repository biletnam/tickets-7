<?php

class SearchController extends Controller{

    /**
     * Создание поискового индекса
     */
    public function getCreate()
    {

        $users =User::all();
        foreach($users as $row){
            Search::index('user')->insert($row->id,[
                'full_name'=>$row->full_name,
                'phone'=>$row->phone,
                'email'=>$row->email
            ]);
        }
    }

    public  function getIndex(){
        $results = Search::index('user')->search(array('email','phone','full_name','title','description','url'), 'Алексеев 3')->get();
        var_dump($results);
    }
}