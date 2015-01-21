@extends('layouts.default')

@section('content')
<h3 xmlns="http://www.w3.org/1999/html">Задачи</h3>
<div class="pod_title_message">
    <? echo urldecode(Input::get("mes"));?>
    @if(Session::has('ticket.create'))
    {{Session::get('ticket.create')}}
    @endif
</div>

<?//=Auth::user()->role?>
<div class="gray-line"></div>
<div class="admin-block">
    <div class="bn-wp-new">
        <div class="admin-img">
            <img src="<?=!empty(Auth::user()->img)? '/files/'.Auth::user()->img:'images/admin.jpg'?>" width="250px;" alt=""/>
        </div>
        <div class="admin-name" style="width: 650px!important;">
            <div class="sertificate">
                <div class="starter-slica">
                    <h4 class="aditional-h4">{{Auth::user()->full_name}}</h4>
                    <ul class="stroger">
                        <li><a class="new-task" href="<?=URL::route('ticket.index',array('status_id'=>1))?>">Новые ({{$countNew}})</a></li>
                    </ul>
                    <div>

                    <div class="filter draser draser-me">
                        <?
                        $ispolnitel = array(''=>'любой') + User::where('role','=','worker')->lists('full_name','id');
                        $user = array(''=>'любой') + User::where('role','=','user')->lists('full_name','id');

                        ;?>
                        {{ Form::open(array('route' =>array('ticket.index'),"role"=>"form","method"=>"get"))}}
                        <p><span class="slister">Номер:</span>{{Form::text('id',Input::get('id'))}}</p>
                        <p><span class="slister">Статус:</span>{{Form::select('status_id', array_merge(array('0'=>'все'),$status),Input::get('status_id',0));}}</p>
                      <!--  <p><span class="slister">Клиент:</span>{{Form::select('user_id', array_merge(array(''=>'любой'),User::where('role','=','user')->lists('full_name','id')),Input::get('user_id',''));}}</p>-->
                        <p><span class="slister">Клиент:</span>{{Form::select('user_id', $user,Input::get('user_id',''));}}</p>
                        <p><span class="slister">Исполнитель:</span>{{Form::select('user_id2', $ispolnitel,Input::get('user_id2',''));}}</p>
                        <p>


                        </p>
                        <p><span class="slister">Дата c:</span>{{Form::text('dt_from',Input::get('dt_from'))}}</p>
                        <p><span class="slister">Дата по:</span>{{Form::text('dt_to',Input::get('dt_to'))}}</p>
                        <p><span class="slister">Время</span>
                            <select name="time_show" id="">
                                <option <?if(Input::get('time_show') == '0') echo "selected";?> value="0">нет</option>
                                <option <?if(Input::get('time_show') == '1') echo "selected";?> value="1">да</option>
                            </select></p>
                        <p class="my_btn ochistit-me">{{ Form::submit('Фильтровать',['class'=>'btn'])}}</p>
                        <p class="ochistit-me-2" style="padding-top: 7px;"><a href="/ticket/">Очистить</a></p>
                        {{Form::close();}}
                    </div>
                </div>
                </div>
                <a class="add-client add-client-med" href="{{URL::route('user.create')}}">Добавить клиента</a>
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>
<?
// peredaem massiv userov
$data = $tickets->users_me;
?>
@if(!empty($tickets))
<table>
    <thead>
    <tr>
        <td class="number"><span class="left-sp"></span>Номер</td>
        <td class="data">дата</td>
        <td class="task">Задача</td>
        <td class="clients">Исполнитель</td>
        <td class="clients">Клиент</td>
        <td class="status">Статус</td>
        <?if(Input::get('time_show') == '1'):?>
        <td class="status time_show">Время</td>
        <?endif;?>
        <td>Действия <span class="right-sp"></span></td>
    </tr>
    </thead>
    <tbody class="tbody">

    <?php
    $vremya = 0;
    $k = 0;
    foreach($tickets as $ticket):?>
        <tr class="<?if($k==0):?>table-info-user<?endif;?> <?if($k+1==count($ticket)):?>last-border<?endif;?>">
            <td onclick="location.href='{{URL::route('ticket.show',array('id'=>$ticket->id))}}'"><?=$ticket->id?></td>
            <td onclick="location.href='{{URL::route('ticket.show',array('id'=>$ticket->id))}}'"><?php $dt = new DateTime($ticket->created_at); echo $dt->format('d.m.Y')?></td>
            <td onclick="location.href='{{URL::route('ticket.show',array('id'=>$ticket->id))}}'"><?=!empty($ticket->title)?$ticket->title:""?></td>
            <td onclick="location.href='{{URL::route('ticket.show',array('id'=>$ticket->id))}}'">

                <?

                if (array_key_exists($ticket->worker, $data)) {
                    if($ticket->worker != '') {
                        echo $data[$ticket->worker];
                    } else {
                        echo "несколько";
                    }
                }
                ?>
              </td>
            <td onclick="location.href='{{URL::route('ticket.show',array('id'=>$ticket->id))}}'"><?=!empty($ticket->user->full_name)? $ticket->user->full_name:'' ?></td>
            <td onclick="location.href='{{URL::route('ticket.show',array('id'=>$ticket->id))}}'"><?=!empty($status[$ticket->status_id])?$status[$ticket->status_id]:''?></td>
            <?if(Input::get('time_show') == '1'):?>
            <td onclick="location.href='{{URL::route('ticket.show',array('id'=>$ticket->id))}}'"><?=!empty($ticket->time_real)? $ticket->time_real:'' ?></td>
            <?endif;?>
            <td><a class="prosmotr_me" href="{{URL::route('ticket.show',array('id'=>$ticket->id))}}">Просмотр</a> <a class="edit_me" href="{{URL::route('ticket.edit',array('id'=>$ticket->id))}}">Редактировать</a></td>
        </tr>
        <? $vremya = $vremya + $ticket->time_real;?>
        <?$k++;?>
    <?php endforeach;?>
    <tr>
        <td class="colvo" colspan="10">Общее количество времени составляет: <strong><?=$vremya?></strong> минута(ы)</td>
    </tr>
    </tbody>
    <tfoot>
    <tr>
        <td><span class="left-sp"></span></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <?if(Input::get('time_show') == '1'):?>
            <td></td>
        <?endif;?>
        <td><span class="right-sp"></span></td>
    </tr>
    </tfoot>
</table>
{{$tickets->appends(Input::except('page'))->links()}}
<p>На странице: {{$tickets->count()}} Всего: {{$tickets->getTotal()}}</p>
@endif
@stop