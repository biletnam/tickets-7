@extends('layouts.default')

@section('content')
<h3>Поиск по результату @if($q) ,{{$q}} @endif</h3>
<div class="gray-line"></div>
<div class="search-list">
@if(empty($data))
    По запросу "{{$q}}" ничего не найдено.
@else
   <articles>
        @foreach($data as $ticket)
            <article>
                <a href="{{URL::route('ticket.show',array('id'=>$ticket->id))}}">№ {{$ticket->id}}</a> {{preg_replace('/('.$q.')/i','<span style="background:#ACE1AF">\1</span>',$ticket->title)}}
                <?$descF=preg_match('/('.$q.')/i',$ticket->description);?>
                @if(!empty($descF))
                    <?
                    $pos = strpos(preg_replace('/('.$q.')/i','<span style="background:#ACE1AF">\1</span>',$ticket->description),'<span');
                    $str =preg_replace('/('.$q.')/i','<span style="background:#ACE1AF">\1</span>',$ticket->description);
                    $length = ($pos+35+strlen($q)+35)>strlen($str) ? (strlen($str)-$pos):($pos+35+strlen($q)+35);
                    ?>
                    <p>{{substr($str,$pos>51?($pos-50):0,$length)}}</p>
                @endif
                <?$commentF = preg_match('/('.$q.')/i',$ticket->comment);?>
                @if(!empty($commentF))
                    <?$pos = strpos(preg_replace('/('.$q.')/i','<span style="background:#ACE1AF">\1</span>',$ticket->comment),'<span');
                                          $str =preg_replace('/('.$q.')/i','<span style="background:#ACE1AF">\1</span>',$ticket->comment);
                                          $length = ($pos+35+strlen($q)+35)>strlen($str) ? (strlen($str)-$pos):($pos+35+strlen($q)+35);?>
                   <p>{{substr($str,$pos>51?($pos-50):0,$length)}}</p>
                @endif
            </article>
        @endforeach
   </articles>
   {{$data->appends(array('q' => $q))->links()}}
@endif
</div>
@stop