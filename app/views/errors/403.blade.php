@extends('layouts.default')
@section('content')
<h1>Ошибка 403</h1>
<p class="message">
    {{$exception->getMessage()}}
</p>
<?php
if(!empty(Auth::user()) && Auth::user()->role=="admin" && Config::get('app.debug')) var_dump($exception);
?>

@stop