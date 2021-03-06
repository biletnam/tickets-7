@extends('layouts.default')

@section('content')
    <h3>{{$worker->full_name}}</h3>
    <div class="gray-line"></div>
    <div class="form-add-block">
        {{ Form::model($worker,array('route' => array('worker.update','worker'=>$worker->id),"role"=>"form","method"=>"PUT",'files'=>true))}}
        <div class="left-form opinion">
            <ul>
                <li>
                    <span class="bold1">Телефон:</span><br/>
                    {{Form::text('phone')}}
                    <label class="error">{{ $errors->first('phone') }}</label>
                </li>
                <li>
                    <span class="bold1">E-mail:</span><br/>
                    {{Form::text('email')}}
                    <label class="error">{{ $errors->first('email') }}</label>
                </li>
                <li>
                    <span class="bold1">Пароль:</span><br/>
                    {{Form::password('password')}}
                    <label class="error">{{ $errors->first('password') }}</label>
                </li>
                <li>
                    <span class="bold1">Подтверждение пароля:</span><br/>
                    {{Form::password('password_confirmation')}}
                    <label class="error">{{ $errors->first('password_confirmation') }}</label>
                </li>
                <li>
                    <span class="bold1">Картинка:</span><br/>
                    {{Form::file('img')}}
                    <label class="error">{{ $errors->first('img') }}</label><br><br>
                    <?if(!empty($worker->img)):?>
                        <img src="/files/{{$worker->img}}" width="300">
                    <?endif;?>
                </li>
                <li class="stricker uio">{{Form::submit('Сохранить',['class'=>'btnx red-btn red-btn-me red-width'])}}</li>
            </ul>
        </div>
        {{Form::close()}}
    </div>
@stop