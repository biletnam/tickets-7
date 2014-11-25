@extends('layouts.default')
@section('content')
<h3>Задача №{{$ticket->id}}</h3>
<div class="gray-line super-grey"></div>
<? //echo "<pre>";print_r($ticket->worker);
//echo "<pre>";
//print_r($ticket);
$ticket->worker = str_replace('[','',$ticket->worker);
$ticket->worker = str_replace(']','',$ticket->worker);


?>
<div class="form-add-block">
    <?if(Session::has('status_id')){
        echo '<div class="alert success">'.Session::get('status_id').'</div>';
    }?>
    <?if(Session::has('error')){
        echo '<div class="alert warning">'.Session::get('error').'</div>';
    }?>
    {{ Form::model($ticket,array('route' => array('ticket.update',"ticket"=>$ticket->id),"role"=>"form","files"=>"true","method"=>"PUT"))}}
    <div class="left-form openss" style="width: 100%">
        <?
        //echo "<pre>";print_r($ticket);
        ?>
        <ul>

            @if(!empty($ticket->title))
            <li><label class="bold1">Название:</label> <span>{{$ticket->title}}</span></li>
            @endif

            @if(!empty($ticket->url))
            <li><label class="label bold1">URL:</label> <span><a href="{{$ticket->url}}">{{$ticket->url}}</a></span></li>
            @endif

            @if(!empty($ticket->description))
            <li>
                {{$ticket->description}}
            </li>
            @endif
            @if(!empty($ticket->file_path))
            <li><a target="_blank" href="{{URL::to('manager',array('ticket'=>$ticket->id))}}">Файл</a></li>
            @endif
            <li><label class="bold1">Приоритет</label>: <span>{{$ticket->priority->title}}</span></li>
            <li><label class="bold1">Статус:</label>
                {{ Form::select('status_id',$statuses) }}
                <label class="error">{{ $errors->first('status_id') }}</label>
            </li>
            @if(Auth::user()->role=="admin")
            <li><label class="bold1" style="vertical-align: top;display: block;">Исполнитель:</label>
                {{ Form::select('worker[]',$users_me, $ww = explode(",", $ticket->worker), array('multiple' => true)) }}
                <label class="error">{{ $errors->first('users_me') }}</label>
            </li>
            <li><label class="bold1">Цена за работу:</label>
                {{ Form::text('price') }}
                <label class="error">{{ $errors->first('price') }}</label>
            </li>
            @endif
            <li><label>Cтатус подтверждения заказчиком:</label>
                {{Form::checkbox('apply',1,$ticket->apply==1)}}
                <label class="error">{{ $errors->first('apply') }}</label>
            </li>
            <li class="my_btn ska">{{ Form::submit('Сохранить',['class'=>'add-work'])}}</li>
        </ul>
    </div>
    {{ Form::close() }}
</div>
@stop