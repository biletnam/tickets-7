@extends('layouts.default')

@section('content')
<h3>Задачи</h3>
@if(Session::has('ticket.create'))
{{Session::get('ticket.create')}}
@endif
<div class="gray-line"></div>
<div class="admin-block">
    <div class="admin-img">
        <img src="images/admin.jpg" alt=""/>
    </div>
    <div class="admin-name">
        <h4>Имя администратора</h4>
        <a class="add-client" href="{{URL::route('user.create')}}">Добавить клиента</a>
        <ul>
            <li><a href="<?=URL::route('ticket.index',array('status_id'=>1))?>">Новые ({{$countNew}})</a></li>
        </ul>
        <div class="filter">
            {{ Form::open(array('route' =>array('ticket.index'),"role"=>"form","method"=>"get"))}}
            <p>Номер:{{Form::text('id',Input::get('id'))}}</p>
            <p>Статус:{{Form::select('status_id', array_merge(array('0'=>'все'),$status),Input::get('status_id',0));}}</p>
            <p>Дата c:{{Form::text('dt_from',Input::get('dt_from'))}}</p>
            <p>Дата по:{{Form::text('dt_to',Input::get('dt_to'))}}</p>
            <p>{{ Form::submit('Фильтровать',['class'=>'btn'])}}</p>
            {{Form::close();}}
        </div>
    </div>
</div>

@if(!empty($tickets))
<table>
    <thead>
    <tr>
        <td class="number"><span class="left-sp"></span>Номер</td>
        <td class="data">дата</td>
        <td class="task">Задача</td>
        <td class="clients">клиент</td>
        <td class="status">Статус</td>
        <td><span class="right-sp"></span></td>
    </tr>
    </thead>
    <tbody class="tbody">

    <?php
    $k = 0;
    foreach($tickets as $ticket):?>
        <tr class="<?if($k==0):?>table-info-user<?endif;?> <?if($k+1==count($ticket)):?>last-border<?endif;?>">
            <td><?=$ticket->id?></td>
            <td><?php $dt = new DateTime($ticket->created_at); echo $dt->format('d.m.Y')?></td>
            <td><?=$ticket->title?></td>
            <td><?=$ticket->user->full_name?></td>
            <td><?=!empty($status[$ticket->status_id]) $status[$ticket->status_id]:''?></td>
            <td><a href="{{URL::route('ticket.show',array('id'=>$ticket->id))}}">Просмотр</a> <a href="{{URL::route('ticket.edit',array('id'=>$ticket->id))}}">Редактировать</a></td>
        </tr>
        <?$k++;?>
    <?php endforeach;?>
    </tbody>
    <tfoot>
    <tr>
        <td><span class="left-sp"></span></td>
        <td></td>
        <td></td>
        <td></td>
        <td><span class="right-sp"></span></td>
    </tr>
    </tfoot>
</table>
{{$tickets->links()}}
@endif
@stop