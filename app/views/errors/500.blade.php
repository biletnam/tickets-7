@extends('layouts.default')
@section('content')
<h1>Ошибка 500</h1>
<p class="message">
    {{$exception->getMessage()}}
</p>
@stop