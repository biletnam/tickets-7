@extends('layouts.default')
@section('content')
<h1>Ошибка 500</h1>
<p class="message">
    {{$exception->getMessage()}}
</p>
<?php
  if(!empty(Auth::user()) && Auth::user()->role=="admin" ) var_dump($exception);
?>
@stop