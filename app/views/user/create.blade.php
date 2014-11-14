@extends('layouts.default')
@section('content')
<h3>добавить пользователя</h3>
<div class="gray-line"></div>
<div class="form-add-block">
    {{ Form::model($user,array('route' => array('user.store'),"role"=>"form"))}}
    <div class="left-form">
        <ul>
            <li>
                <span>Контактное Лицо:</span><br/>
                {{Form::text('full_name')}}
                <label class="error">{{ $errors->first('full_name') }}</label>
            </li>
            <li>
                <span>email(Логин):</span><br/>
                {{Form::text('email')}}
                <label class="error">{{ $errors->first('email') }}</label>
            </li>
            <li>
                <span>Телефон:</span><br/>
                {{Form::text('phone')}}
                <label class="error">{{ $errors->first('phone') }}</label>
            </li>
            <li class="password-me">
                <label>Пароль:</label>
                {{Form::password('password')}}
                <label class="error">{{ $errors->first('password') }}</label>
            </li>
            <li class="password-me">
                <label>Подтверждение пароля:</label>
                {{Form::password('password_confirmation')}}
                <label class="error">{{ $errors->first('password_confirmation') }}</label>
            </li>
            <li class="select-s">
                <label>Права:</label>
                {{Form::select('role',array('user'=>'Клиент','admin'=>'Администратор'))}}
                <label class="error">{{ $errors->first('role') }}</label>
            </li>
            <li class="add-worl-me">
                {{ Form::submit('Добавить клиента',['class'=>'add-work'])}}
            </li>
        </ul>
    </div>
    {{ Form::close() }}
</div>
@stop