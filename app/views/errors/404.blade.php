@extends('layouts.default')
@section('content')
<h1>Ошибка 404</h1>
<p class="message">

</p>
@if(Auth::user()->role=="admin" )
<?var_dump($exception)?>
@endif

@stop