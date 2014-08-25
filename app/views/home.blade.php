@extends('layouts.default')

@section('content')
    @if (!Auth::check())
        @if(!Request::is('login'))
            @include('include.auth')
        @else
            @include('include.main')
        @endif
    @endif
@stop