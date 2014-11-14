@extends('layouts.default')
@section('content')
<h3 class="bn-wp">Задачи</h3>
@if(Session::has('ticket.create'))
{{Session::get('ticket.create')}}
@endif
<div class="bn-wp start_up">
    <a href="{{URL::route('ticket.index',array('apply'=>0))}}" class="button">Задачи требующие подтверждения</a>
</div>
@if(!empty($tickets))
<table>
    <thead>
    <tr>
        <td class="number"><!--<span class="left-sp"></span>-->Номер</td>
        <td class="task">Задача</td>
        <td class="clients">Статус</td>
        <td class="status">Стоимость</td>
        <td><!--<span class="right-sp"></span>--></td>
    </tr>
    </thead>
    <tbody class="tbody">

    <?php
    $k = 0;
    foreach($tickets as $ticket):?>
        <tr class="<?if($k==0):?>table-info-user<?endif;?> <?if($k+1==count($ticket)):?>last-border<?endif;?>">
            <td><?=$ticket->id?></td>
            <td><?=$ticket->title?></td>
            <td><?=$status[$ticket->status_id]?></td>
            <td><?=number_format($ticket->price,0,'',' ')?></td>
            <td><a href="{{URL::route('ticket.show',array('id'=>$ticket->id))}}">Просмотр</a></td>
        </tr>
        <?$k++;?>
    <?php endforeach;?>
    </tbody>
    <tfoot class="me-tfoot">
    <tr>
        <td><!--<span class="left-sp"></span>--></td>
        <td></td>
        <td></td>
        <td></td>
        <td><!--<span class="right-sp"></span>--></td>
    </tr>
    </tfoot>
</table>
{{$tickets->links()}}
@endif
@stop