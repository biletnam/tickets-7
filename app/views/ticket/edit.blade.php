@extends('layouts.default')
@section('content')
<h3>Задача №{{$ticket->id}}</h3>
<div class="gray-line"></div>
<div class="form-add-block">
    <?if(Session::has('status_id')){
       echo '<div class="alert success">'.Session::get('status_id').'</div>';
    }?>
    <?if(Session::has('error')){
        echo '<div class="alert warning">'.Session::get('error').'</div>';
    }?>
    {{ Form::model($ticket,array('route' => array('ticket.update',"ticket"=>$ticket->id),"role"=>"form","files"=>"true","method"=>"PUT"))}}
    <div class="left-form">
        <ul>

            @if(!empty($ticket->title))
            <li><label>Название:</label> <span>{{$ticket->title}}</span></li>
            @endif

            @if(!empty($ticket->url))
            <li><label class="label">URL:</label> <span><a href="{{$ticket->url}}">{{$ticket->url}}</a></span></li>
            @endif

            @if(!empty($ticket->description))
            <li>
                {{$ticket->description}}
            </li>
            @endif
            @if(!empty($ticket->file_path))
            <li><a target="_blank" href="{{URL::to('manager',array('ticket'=>$ticket->id))}}">Файл</a></li>
            @endif
            <li><label>Приоритет</label>: <span>{{$ticket->priority->title}}</span></li>
            <li><label>Статус:</label>
                {{ Form::select('status_id',$statuses) }}
                <label class="error">{{ $errors->first('status_id') }}</label>
            </li>
            @if(Auth::user()->role=="admin")
            <li><label>Цена за работу:</label>
                {{ Form::text('price') }}
                <label class="error">{{ $errors->first('price') }}</label>
            </li>
            @endif
            <li><label>Cтатус подтверждения заказчиком:</label>
                {{Form::checkbox('apply',1,$ticket->apply==1)}}
                <label class="error">{{ $errors->first('apply') }}</label>
            </li>
            <li>{{ Form::submit('Сохранить',['class'=>'add-work'])}}</li>
        </ul>
    </div>
    {{ Form::close() }}
</div>
@stop