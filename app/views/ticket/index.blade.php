@extends('layouts.default')

@section('content')
<h1>Список задач</h1>
@if(Session::has('ticket.create'))
{{Session::get('ticket.create')}}
@endif
@stop