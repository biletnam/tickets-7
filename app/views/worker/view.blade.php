@extends('layouts.default')

@section('content')
<h3>{{$worker->full_name}} <a href="{{URL::route('worker.edit',array($worker->id))}}">EDIT</a></h3>
<div class="gray-line"></div>
<div class="form-view">
    @if(Session::has('phone'))
    {{'<div class="alert success">'.Session::get('phone').'</div>'}}
    @endif
    @if(Session::has('email'))
    {{ '<div class="alert success">'.Session::get('email').'</div>'}}
    @endif
    @if(Session::has('password'))
    {{'<div class="alert success">'.Session::get('password').'</div>'}}
    @endif
    @if(Session::has('error'))
    {{'<div class="alert warning">'.Session::get('error').'</div>'}}
    @endif
    <ul>
        <li>
            <label class="bold1">Телефон:</label>
            {{$worker->phone}}
        </li>
        <li>
            <label class="bold1">E-mail:</label>
            {{$worker->email}}
        </li>
        <li>
            <label class="bold1">Баланс:</label>
            {{$worker->balance}}
        </li>
        <li>
            <label class="bold1">Права:</label>
            {{$worker->role=="admin"? "Администратор":"Исполнитель"}}
        </li>
        <?if(!empty($worker->img)):?>
        <li><img src="/files/{{$worker->img}}" width="300"></li>
        <?endif;?>
    </ul>

</div>
@stop