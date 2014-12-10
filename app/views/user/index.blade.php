@extends('layouts.default')

@section('content')
<h3>Список пользователей</h3>
@if(Session::has('user.create'))
{{Session::get('user.create')}}
@endif
<div class="gray-line"></div>
<div class="bn-wp-new">
    <div class="admin-name" style="float: right;">
        <a class="add-client" href="{{URL::route('user.create')}}">Добавить клиента</a>
    </div>
    <div class="filter slisters dubstep" style="width: 390px;float: left;clear: none!important;">
        {{ Form::open(array('route' =>array('user.index'),"role"=>"form","method"=>"get"))}}
        <p><span class="slister">Номер:</span>{{Form::text('id',Input::get('id'))}}</p>
        <p><span class="slister">ФИО:</span>{{Form::text('full_name',Input::get('full_name'))}}</p>
        <p><span class="slister">E-mail:</span>{{Form::text('email',Input::get('email'))}}</p>
        <p><span class="slister">Телефон:</span>{{Form::text('phone',Input::get('phone'))}}</p>
        <p><span class="slister">Роль:</span>{{Form::select('role',['0'=>'Любой','admin'=>'Администратор','user'=>'Клиент'],Input::get('role',0))}}</p>
        <p  class="ochistit-me"><span>{{ Form::submit('Фильтровать',['class'=>'btn'])}}</p>
        <p class="ochistit-me-2" style="padding-top: 15px"><a href="/user/">Очистить</a></p>
        {{Form::close();}}
    </div>
    <div class="clear"></div>
</div>
@if(!empty($users))
<table class="table-sop">
    <thead>
    <tr>
        <td class="number"><span class="left-sp"></span>Номер</td>
        <td class="">Баланс</td>
        <td class="">Имя</td>
        <td class="">Телефон</td>
        <td class="">E-mail</td>
        <td><span class="right-sp"></span></td>
    </tr>
    </thead>
    <tbody class="tbody">

    <?php
    $k = 0;
    foreach($users as $user):?>
        <tr class="<?if($k==0):?>table-info-user<?endif;?> <?if($k+1==count($users)):?>last-border<?endif;?>">
            <td><?=$user->id?></td>
            <td><?=$user->balance?></td>
            <td><?=$user->full_name?></td>
            <td><?=$user->phone?></td>
            <td><?=$user->email?></td>
            <td class="action-btn"><!--<span class="right-sp"></span>-->
                <a class="view" href="{{URL::route('user.show',array('id'=>$user->id))}}"><span class="see-me"></span></a>
                <a class="edit" href="{{URL::route('user.edit',array('id'=>$user->id))}}"><span class="edit-me"></span></a>
                {{Form::model('$user',array('route'=>array('user.destroy',$user->id),'method'=>'DELETE'))}} {{Form::submit('Delete')}} {{Form::close()}}
            </td>
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
        <td></td>
        <td><span class="right-sp"></span></td>
    </tr>
    </tfoot>
</table>
{{$users->links()}}
<p>На странице: {{$users->count()}} Всего: {{$users->getTotal()}}</p>
@endif


@stop