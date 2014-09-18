@extends('layouts.default')
@section('content')
<h1>Ошибка 403</h1>
<p class="message">
    {{$exception->getMessage()}}
</p>
@if(Auth::user()->role=="admin" )
<?var_dump($exception)?>
@endif

@stop