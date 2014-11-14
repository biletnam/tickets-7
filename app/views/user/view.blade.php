@extends('layouts.default')

@section('content')
<h3>{{$user->full_name}} <a href="{{URL::route('user.edit',array($user->id))}}">EDIT</a></h3>
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
            {{$user->phone}}
        </li>
        <li>
            <label class="bold1">E-mail:</label>
            {{$user->email}}
        </li>
        <li>
            <label class="bold1">Баланс:</label>
            {{$user->balance}}
        </li>
        <li>
            <label class="bold1">Права:</label>
            {{$user->role=="admin"? "Администратор":"Клиент"}}
        </li>
    </ul>

</div>
@stop