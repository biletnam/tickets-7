@extends('layouts.default')

@section('content')
<style>
    #simplemodal-container {
        height: 380px!important;
        width: 422px!important;
    }
</style>
<p class="slogon">Студия осуществляет техническую поддержку сайтов <br/>на любых системах управления, в том числе и самописных.</p>
<p class="orange-text">Особенно любим:</p>
<p class="cms"><span>1C-Битрикс</span>   <!-- <span>Joomla</span>    <span>Wordpress</span>--></p>
<div class="line"></div>
<ul class="processing-time">
    <li><strong>Срок обработки</strong> заявки в будние дни - 1 час.</li>
    <li><strong>Средний срок выполнения</strong> задачи - 1 день.</li>
</ul>
<div class="form-block">
    {{ Form::open(array('url' => 'login','role'=>'form')) }}
    @if(!empty($errors->get('login')[0]))
    <label class="error">{{$errors->get('login')[0]}}</label>
    @endif
    {{ Form::text('email',null,array('placeholder'=>'Email')) }}
    {{ Form::password('password',array('placeholder'=>'Пароль')) }}
    {{ Form::submit('Войти', array()) }}
    {{ Form::close() }}
    <!--<span><a id="modal" href="#">Забыли пароль?</a></span>-->
</div>
<div class="btn-block beclient-me">
    <a class="red-btn" href="#">Стать клиентом</a>
</div>
<div class="content register-me">
    <div class=" inner-block">
        <div class="form-block form-block-me">
            <p class="cms cms-me" style="padding-top: 10px;"></p>
            <form role="form" accept-charset="UTF-8" action="http://tickets/login" method="POST"><input type="hidden" value="Dnb0r2EnM1KhUc6b7PR8oLtSkfkpAsufIg9XJT9N" name="_token">
                <input type="text" name="name-me" placeholder="Имя">
                <input type="text" name="phone-me" placeholder="Телефон">
                <input type="text" name="email-me" placeholder="E-mail">
                <textarea name="message-me" id="" cols="30" rows="10" placeholder="Введите сообщение"></textarea>
                <input class="btn" type="submit" value="Зарегистрироваться">
            </form>
        </div>
    </div>
</div>
@stop