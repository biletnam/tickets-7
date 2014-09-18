@extends('layouts.default')
@section('content')
    @if(!empty($code))
        <h1>{{$code}}</h1>
    @endif
    {{$exception->getMessage()}}
@stop