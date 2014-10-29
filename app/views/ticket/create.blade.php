@extends('layouts.default')
@section('content')
<h3>добавить Задачу</h3>
<div class="gray-line"></div>
<div class="form-add-block">
    {{ Form::model($ticket,array('route' => array('ticket.store'),"role"=>"form","files"=>"true"))}}
    <div class="left-form">
        <ul>
            <li>
                <span>Название задачи:</span><br/>
                {{Form::text('title')}}
                <label class="error">{{ $errors->first('title') }}</label>
            </li>
            <li>
                <span>URL адрес страницы, для которой ставится задача:</span><br/>
                <span>(вводите полный путь с http://)</span><br>
                {{Form::text('url','',array('placeholder'=>'http://example.com/test.php')) }}
                <label class="error">{{ $errors->first('url') }}</label>
            </li>
            <li>
                <span>Описание:</span><br/>
                {{ Form::textarea('description')}}
            </li>
            <li>
                <span class="add-file">Прикрепить файл <span>(не больше 8 Мб.)</span>:</span><br/>
                {{Form::file('file_path')}}
                <label class="error">{{ $errors->first('file_path') }}</label>
            </li>
        </ul>
    </div>
    <div class="right-form">
        <label class="error">{{ $errors->first('priority_id') }}</label>
        <ul>
            @foreach($priorities as $item)
                <li>
                    <label>{{Form::radio('priority_id',$item->id)}} {{$item->title}}</label>
                    <span>{{$item->description}}</span>
                </li>
            @endforeach
        </ul>
        {{Form::hidden('user_id',Auth::user()->id)}}
        {{ Form::submit('Добавить задачу',['class'=>'add-work'])}}
    </div>
    {{ Form::close() }}
</div>
@stop