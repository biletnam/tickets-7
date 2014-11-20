@extends('layouts.default')

@section('content')
<h3>Задачи</h3>
@if(Session::has('ticket.create'))
{{Session::get('ticket.create')}}
@endif
<div class="gray-line"></div>
<div class="admin-block">
    <div class="bn-wp">
        <div class="admin-img">
            <img src="<?=!empty(Auth::user()->img)? '/files/'.Auth::user()->img:'images/admin.jpg'?>" width="250px;" alt=""/>
        </div>
        <div class="admin-name">
            <h4>{{Auth::user()->full_name}}</h4>
            <a class="add-client" href="{{URL::route('user.create')}}">Добавить клиента</a>
            <ul class="stroger">
                <li><a href="<?=URL::route('ticket.index',array('status_id'=>1))?>">Новые ({{$countNew}})</a></li>
            </ul>
            <div class="filter draser">
                {{ Form::open(array('route' =>array('ticket.index'),"role"=>"form","method"=>"get"))}}
                <p><span class="slister">Номер:</span>{{Form::text('id',Input::get('id'))}}</p>
                <p><span class="slister">Статус:</span>{{Form::select('status_id', array_merge(array('0'=>'все'),$status),Input::get('status_id',0));}}</p>
                <p><span class="slister">Клиент:</span>{{Form::select('user_id', array_merge(array(''=>'любой'),User::where('role','!=','admin')->lists('full_name','id')),Input::get('user_id',''));}}</p>
                <p><span class="slister">Дата c:</span>{{Form::text('dt_from',Input::get('dt_from'))}}</p>
                <p><span class="slister">Дата по:</span>{{Form::text('dt_to',Input::get('dt_to'))}}</p>
                <p class="my_btn">{{ Form::submit('Фильтровать',['class'=>'btn'])}}</p>
                <p><a href="/ticket/">Очистить</a></p>
                {{Form::close();}}
            </div>
        </div>
    </div>
</div>

@if(!empty($tickets))
<table>
    <thead>
    <tr>
        <td class="number"><!--<span class="left-sp"></span>-->Номер</td>
        <td class="data">дата</td>
        <td class="task">Задача</td>
        <td class="clients">клиент</td>
        <td class="status">Статус</td>
        <td>Действия<!--span class="right-sp"></span>--></td>
    </tr>
    </thead>
    <tbody class="tbody">

    <?php
    $k = 0;
    foreach($tickets as $ticket):?>
        <tr class="<?if($k==0):?>table-info-user<?endif;?> <?if($k+1==count($ticket)):?>last-border<?endif;?>">
            <td onclick="location.href='{{URL::route('ticket.show',array('id'=>$ticket->id))}}'"><?=$ticket->id?></td>
            <td onclick="location.href='{{URL::route('ticket.show',array('id'=>$ticket->id))}}'"><?php $dt = new DateTime($ticket->created_at); echo $dt->format('d.m.Y')?></td>
            <td onclick="location.href='{{URL::route('ticket.show',array('id'=>$ticket->id))}}'"><?=!empty($ticket->title)?$ticket->title:""?></td>
            <td onclick="location.href='{{URL::route('ticket.show',array('id'=>$ticket->id))}}'"><?=!empty($ticket->user->full_name)? $ticket->user->full_name:'' ?></td>
            <td onclick="location.href='{{URL::route('ticket.show',array('id'=>$ticket->id))}}'"><?=!empty($status[$ticket->status_id])?$status[$ticket->status_id]:''?></td>
            <td><a class="prosmotr_me" href="{{URL::route('ticket.show',array('id'=>$ticket->id))}}">Просмотр</a> <a class="edit_me" href="{{URL::route('ticket.edit',array('id'=>$ticket->id))}}">Редактировать</a></td>
        </tr>
        <?$k++;?>
    <?php endforeach;?>
    </tbody>
    <tfoot>
    <tr>
        <td><!--<span class="left-sp"></span>--></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><!--<span class="right-sp"></span>--></td>
    </tr>
    </tfoot>
</table>
{{$tickets->links()}}
<p>На странице: {{$tickets->count()}}, Всего: {{$tickets->getTotal()}}</p>
@endif
@stop