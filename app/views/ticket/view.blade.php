@extends('layouts.default')
@section('content')
<h3>Задача № {{$ticket->id}} @if(Auth::user()->role=='admin')<a href="<?=URL::route('ticket.edit',array($ticket->id))?>">Edit</a>@endif</h3>
<div class="gray-line"></div>
<div class="form-add-block">
    <?if(Session::has('status_id')){
        echo '<div class="alert success">'.Session::get('status_id').'</div>';
    }?>
    <?if(Session::has('error')){
        echo '<div class="alert warning">'.Session::get('error').'</div>';
    }?>
    <div class="view-block">
        <ul>
            @if(!empty($ticket->title))
            <li><label class="label">Название:</label> <span>{{$ticket->title}}</span></li>
            @endif

            @if(!empty($ticket->url))
            <li><label>URL:</label>: <span><a href="{{$ticket->url}}">{{$ticket->url}}</a></span></li>
            @endif

            @if(!empty($ticket->description))
            <li>
                {{$ticket->description}}
            </li>
            @endif
            @if(!empty($ticket->file_path))
                <li><a target="_blank" href="<?echo substr($ticket->file_path,strpos($ticket->file_path,'web-kmv.ru')+10)?>">Файл</a></li>
                <?/*<li><a target="_blank" href="{{URL::to('manager',array('ticket'=>$ticket->id))}}">Файл</a></li>*/?>
            @endif

            <li><label>Приоритет</label>: <span>{{$ticket->priority->title}}</span></li>
            <li><label>Статус</label>: <span>{{$ticket->status->title}}</span></li>
            <li><label>Дата создания</label>: <span><?$dt = new DateTime($ticket->created_at); echo  $dt->format('d.m.Y H:i')?></span></li>
            <li><label>Стоимость работы</label>: <span><?=number_format($ticket->price,0,'',' ')?></span></li>
            @if(Auth::user()->role=='admin')
            <li><label>Cтатус подтверждения заказчиком</label>: <span><?=$ticket->apply==0 ? "Не подтвержден":"Подтвержден"?></span></li>
            @else
                @if($ticket->apply==0)
                <li>
                    {{Form::model($ticket,array('route' => array('ticket.update',"ticket"=>$ticket->id),"role"=>"form","method"=>"PUT"))}}
                        {{Form::hidden('apply',1)}}
                        {{ Form::submit('Подтвердить',['class'=>'add-work'])}}
                    {{Form::close();}}
                </li>
                @endif
            @endif
        </ul>
    </div>
</div>
<h3 class="comment-title">
    Комментарии
</h3>
<div class="form-comment">
    {{Form::open(array("href"=>URL::to('comment'),"id"=>"commentForm","method"=>"post"))}}
        <p>
            <label>
                <textarea name="comment"></textarea>
            </label>
        </p>
        <p>
            <input type="hidden" name="controller" value="<?=URL::to('comment')?>" >
            <input type="hidden" name="ticket_id" value="<?=$ticket->id?>" >
            <input type="submit" value="Комментировать">
        </p>
    {{Form::close()}}
</div>
<?if(!empty($ticket->commets()->get())):?>
<div class="comments">
    <?foreach($ticket->commets()->get() as $comment){?>
        <div class="comment <?=Auth::user()->role?>">
            <p clas="about"><span class="date"><?$dt = new DateTime($comment->created_at); echo $dt->format('d.m.Y H:i')?></span> <span class="author"><?=$comment->user->full_name?></span></p>
            <div>{{$comment->comment}}</div>
        </div>
    <?}?>
</div>
<?endif?>
@stop