@extends('layouts.default')

@section('content')
<p class="slogon">Студия осуществляет техническую поддержку сайтов <br/>на любых системах управления, в том числе и самописных.</p>
<p class="orange-text">Особенно любим:</p>
<p class="cms"><span>1C-Битрикс</span>    <span>Joomla</span>    <span>Wordpress</span></p>
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
    <span><a id="modal" href="#">Забыли пароль?</a></span>
</div>
<div class="btn-block">
    <a class="red-btn" href="#">Стать клиентом</a>
</div>
@stop