@extends('layouts.default')

@section('content')
<h3>Поиск по результату @if($q) ,{{$q}} @endif</h3>
<div class="gray-line"></div>
<div class="search-list">
    {{var_dump($dbResult)}};
    @foreach($dbResult as $item)
        <div class="elment">
            <p><label>Имя:</label> <span></span></p>
            <p><label>Телефон:</label> <span></span></p>
            <p><label>Email:</label> <span></span></p>
        </div>
    @endforeach
</div>
@stop