@extends('layouts.default')

@section('content')
<h3>Список пользователей</h3>
@if(Session::has('worker.create'))
{{Session::get('worker.create')}}
@endif
<div class="gray-line"></div>
<div class="bn-wp">
    <div class="admin-name">
        <a class="add-client add-worker" href="{{URL::route('worker.create')}}">Добавить исполнителя</a>
    </div>
    <div class="filter slisters">
        {{ Form::open(array('route' =>array('worker.index'),"role"=>"form","method"=>"get"))}}
        <p><span class="slister">Номер:</span>{{Form::text('id',Input::get('id'))}}</p>
        <p><span class="slister">ФИО:</span>{{Form::text('full_name',Input::get('full_name'))}}</p>
        <p><span class="slister">E-mail:</span>{{Form::text('email',Input::get('email'))}}</p>
        <p><span class="slister">Телефон:</span>{{Form::text('phone',Input::get('phone'))}}</p>
        <p><span class="slister">Роль:</span>{{Form::select('role',['worker'=>'Исполнитель'],Input::get('role',0))}}</p>
        <p><span>{{ Form::submit('Фильтровать',['class'=>'btn'])}}</p>
        <p><a href="/worker/">Очистить</a></p>
        {{Form::close();}}
    </div>
</div>
@if(!empty($worker))
<table class="table-sop">
    <thead>
    <tr>
        <td class="number"><!--<span class="left-sp"></span>-->Номер</td>
        <td class="">Баланс</td>
        <td class="">Имя</td>
        <td class="">E-mail</td>
        <td class="">Телефон</td>
        <td><!--<span class="right-sp"></span>--></td>
    </tr>
    </thead>
    <tbody class="tbody">
    <?php
    $k = 0;
    foreach($worker as $user):?>
        <tr class="<?if($k==0):?>table-info-user<?endif;?> <?if($k+1==count($worker)):?>last-border<?endif;?>">
            <td><?=$user->id?></td>
            <td><?=$user->balance?></td>
            <td><?=$user->full_name?></td>
            <td><?=$user->phone?></td>
            <td><?=$user->email?></td>
            <td class="action-btn"><!--<span class="right-sp"></span>-->
                <a class="view" href="{{URL::route('worker.show',array('id'=>$user->id))}}"><span class="see-me"></span></a>
                <a class="edit" href="{{URL::route('worker.edit',array('id'=>$user->id))}}"><span class="edit-me"></span></a>
                {{Form::model('$worker',array('route'=>array('worker.destroy',$user->id),'method'=>'DELETE'))}} {{Form::submit('Delete')}} {{Form::close()}}
            </td>
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
{{$worker->links()}}
<p>На странице: {{$worker->count()}}, Всего: {{$worker->getTotal()}}</p>
@endif


@stop