@extends('layouts.default')
@section('content')
<h3>Задача № {{$ticket->id}} <a href="<?=URL::route('ticket.edit',array($ticket->id))?>">Edit</a></h3>
<div class="gray-line"></div>
<div class="view-block">
    <ul>
        @if(!empty($ticket->url))
        <li><label>URL:</label>: <span><a href="$ticket->url">{{$ticket->url}}</a></span></li>
        @endif

        @if(!empty($ticket->title))
        <li><label class="label">Название:</label> <span>{{$ticket->title}}</span></li>
        @endif

        @if(!empty($ticket->description))
        <li>
            {{$ticket->description}}
        </li>
        @endif
        @if(!empty($ticket->file_path))
            <li><a target="_blank" href="{{URL::to('manager',array('ticket'=>$ticket->id))}}">Файл</a></li>
        @endif

        <li><label>Статус</label>: <span>{{$ticket->status->title}}</span></li>
        <li><label>Дата создания</label>: <span><?$dt = new DateTime($ticket->created_at); echo  $dt->format('d.m.Y H:i')?></span></li>
        <li><label>Стоимость работы</label>: <span><?=number_format($ticket->price,0,'',' ')?></span></li>
        <li><label>Cтатус подтверждения заказчиком</label>: <span><?=$ticket->apply==0 ? "Не подтвержден":"Подтвержден"?></span></li>
    </ul>
</div>
@stop