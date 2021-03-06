@extends('layouts.default')
@section('content')
<h3 xmlns="http://www.w3.org/1999/html">Задача № {{$ticket->id}}  @if(Auth::user()->role=='admin')<a href="<?=URL::route('ticket.edit',array($ticket->id))?>">Редактировать</a>@endif</h3>
<div class="gray-line"></div>
<div class="bn-wp-me">
    <div class="admin-img">
        @if(!empty($ticket->user->img))
            <img alt="" src="/files/{{$ticket->user->img}}" width="300">
        @else
            <img alt="" src="/images/admin.jpg">
        @endif
    </div>
    <div class="admin-name">
        <div class="form-add-block">
            <?if(Session::has('status_id')){
                echo '<div class="alert success">'.Session::get('status_id').'</div>';
            }?>
            <?if(Session::has('error')){
                echo '<div class="alert warning">'.Session::get('error').'</div>';
            }?>
            <div class="view-block view-block-me">
                @if(!empty($ticket->title))
                <p><strong>Название:</strong> {{$ticket->title}}</p>
                @endif

                @if(!empty($ticket->url))
                <p><label class="bold1 open-air">URL:</label> <span><a href="{{$ticket->url}}">{{$ticket->url}}</a></span></p>
                @endif

                @if(!empty($ticket->file_path))
                <p><a target="_blank" href="<?echo substr($ticket->file_path,strpos($ticket->file_path,'web-kmv.ru')+10)?>">Файл</a></p>
                <p><a target="_blank" href="<?echo substr($ticket->file_path2,strpos($ticket->file_path2,'web-kmv.ru')+10)?>">Файл</a></p>
                <p><a target="_blank" href="<?echo substr($ticket->file_path3,strpos($ticket->file_path3,'web-kmv.ru')+10)?>">Файл</a></p>
                <?/*<li><a target="_blank" href="{{URL::to('manager',array('ticket'=>$ticket->id))}}">Файл</a></li>*/?>
                @endif

                <p><label class="bold1 open-air">Приоритет</label>: <span>{{$ticket->priority->title}}</span></p>
                <p><label class="bold1 open-air">Статус</label>: <span>{{$ticket->status->title}}</span></p>
                <p><label class="bold1 open-air">Дата создания</label>: <span><?$dt = new DateTime($ticket->created_at); echo  $dt->format('d.m.Y H:i')?></span></p>
                <p><label class="bold1 open-air">Стоимость работы</label>: <span><?=number_format($ticket->price,0,'',' ')?></span></p>
                @if(Auth::user()->role=='admin')
                <p><label class="bold1 open-air">Cтатус подтверждения заказчиком</label>: <span><?=$ticket->apply==0 ? "Не подтвержден":"Подтвержден"?></span></p>
                @else
                @if(Auth::user()->role=='user')
                @if($ticket->apply==0)
                <p class="gluper stricker">
                    {{Form::model($ticket,array('route' => array('ticket.update',"ticket"=>$ticket->id),"role"=>"form","method"=>"PUT"))}}
                    {{Form::hidden('apply',1)}}
                    {{ Form::submit('Подтвердить',['class'=>'add-work  red-btn red-btn-me '])}}
                    {{Form::close();}}
                </p>
                @endif
                @endif
                @endif


                <p>
                    @if(Auth::user()->role=='worker' || Auth::user()->role=='admin')
                        @if($ticket->status_id!='6')
                        <a href="?status_id=6">Отправить на проверку</a>
                        @else
                        Отправлено на проверку
                        @endif
                    @endif
                </p>
            </div>
        </div>
    </div>
    <div class="clear"></div>
</div>
@if(!empty($ticket->description))
<p class="scver">
    <strong class="open-air">Описание:</strong>
    {{$ticket->description}}
</p>
@endif
<div class="zadach-block-me {{Auth::user()->role}}">
    <span class="comments-me">Комментарии</span>
    <div class="clearfix"></div>
    <div class="white-bock">
        <? //echo "<pre>";print_r(Auth::user()->img);?>
        <input class="img_com_h" type="hidden" value="/files/<?=Auth::user()->img;?>"/>
        <?php
        $comments  =$ticket->commets()->get();
        ?>

        @if(!empty($comments))
            @foreach($comments as $comment)
                <div class="section">
                    <?
                    //print_r($comment->user->img);exit;
                    ?>
                    @if(!empty($comment->user->img))
                        <img src="/files/{{$comment->user->img}}" width="65" alt=""/>
                    @else
                        <img src="/images/pic1.jpg" alt=""/>
                    @endif
                    <h5>{{$comment->user->full_name}}</h5>
                    <p>{{$comment->comment}}</p>
                    <span class="time"><?$dt = new DateTime($comment->created_at); echo $dt->format('d.m.Y H:i')?></span>
                </div>
            @endforeach
        @endif

    </div>
    <div class="comment-error"></div>
    <div class="form-comment comment-me">
        {{Form::open(array("href"=>URL::to('comment'),"id"=>"commentForm","method"=>"post"))}}
        <p>
            <label>
                <textarea class="txt-are" name="comment"></textarea>
            </label>
        </p>
        <p>
            <input type="hidden" name="controller" value="<?=URL::to('comment')?>" >
            <input type="hidden" name="ticket_id" value="<?=$ticket->id?>" >
            <input class="red-btn red-btn-me red-width" type="submit" value="Комментировать">
        </p>
        {{Form::close()}}
    </div>
</div>
@stop