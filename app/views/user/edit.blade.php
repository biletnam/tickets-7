@extends('layouts.default')

@section('content')
    <h3>{{$user->full_name}}</h3>
    <div class="gray-line"></div>
    <div class="form-add-block">
        {{ Form::model($user,array('route' => array('user.update','user'=>$user->id),"role"=>"form","method"=>"PUT"))}}
            <ul>
                <li>
                    <label>Телефон:</label>
                    {{Form::text('phone')}}
                    <label class="error">{{ $errors->first('phone') }}</label>
                </li>
                <li>
                    <label>E-mail:</label>
                    {{Form::text('email')}}
                    <label class="error">{{ $errors->first('email') }}</label>
                </li>
                <li>
                    <label>Пароль:</label>
                    {{Form::password('password')}}
                    <label class="error">{{ $errors->first('password') }}</label>
                </li>
                <li>
                    <label>Подтверждение пароля:</label>
                    {{Form::password('password_confirmation')}}
                    <label class="error">{{ $errors->first('password_confirmation') }}</label>
                </li>
                <li>{{Form::submit('Сохранить',['class'=>'add-work'])}}</li>
            </ul>
        {{Form::close()}}
    </div>
@stop