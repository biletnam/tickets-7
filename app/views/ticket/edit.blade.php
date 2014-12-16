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
            <li><label class="bold1 open-air">Название:</label> <span>{{$ticket->title}}</span></li>
            @endif

            @if(!empty($ticket->url))
            <li><label class="label bold1">URL:</label> <span><a href="{{$ticket->url}}">{{$ticket->url}}</a></span></li>
            @endif
            @if(!empty($ticket->file_path))
            <li><a target="_blank" href="{{$ticket->file_path}}">Файл</a></li>
            @endif
            @if(!empty($ticket->file_path2))
            <li><a target="_blank" href="{{$ticket->file_path2}}">Файл</a></li>
            @endif
            @if(!empty($ticket->file_path3))
            <li><a target="_blank" href="{{$ticket->file_path3}}">Файл</a></li>
            @endif
            <li><label class="bold1 open-air">Приоритет</label>: <span>{{$ticket->priority->title}}</span></li>
            <li><label class="bold1 open-air">Статус:</label>
                {{ Form::select('status_id',$statuses) }}
                <label class="error">{{ $errors->first('status_id') }}</label>
            </li>
            @if(Auth::user()->role=="admin")
            <li><label class="bold1 open-air" style="vertical-align: top;display: block;">Исполнитель:</label>
                {{ Form::select('worker[]',$users_me, $ww = explode(",", $ticket->worker), array('multiple' => true)) }}
                <label class="error">{{ $errors->first('users_me') }}</label>
            </li>
            <li class="price-me-title"><label class="bold1 open-air">Стоимость:</label>
                {{ Form::text('price') }}
                <label class="error">{{ $errors->first('price') }}</label>
            </li>
            <li class="price-me-title"><label class="bold1 open-air">Предполагаемое время:</label>
                {{ Form::text('time_expected') }}
                <label class="error">{{ $errors->first('time_expected') }}</label>
            </li>
            <li class="price-me-title"><label class="bold1 open-air">Затраченное время:</label>
                {{ Form::text('time_real') }}
                <label class="error">{{ $errors->first('time_real') }}</label>
            </li>
            @endif
            <li style="margin-top: 7px;"><label class="bold1     open-air">Cтатус подтверждения заказчиком:</label>
                {{Form::checkbox('apply',1,$ticket->apply==1)}}
                <label class="error">{{ $errors->first('apply') }}</label>
            </li>
            @if(!empty($ticket->description))
            <li class="super-ramka">
                {{$ticket->description}}
            </li>
            <input type="hidden" value="0" name="save_new"/>
            @endif
            <li class="my_btn ska save_new">{{ Form::submit('Сохранить и закрыть',['class'=>'add-work btnx red-btn red-btn-me red-width'])}}</li>
            <li class="my_btn ska">{{ Form::submit('Сохранить и продолжить',['class'=>'add-work btnx red-btn red-btn-me red-width'])}}</li>
        </ul>
    </div>
    {{ Form::close() }}
</div>
@stop