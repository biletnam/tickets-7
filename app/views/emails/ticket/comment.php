<p>Отправлено от: <? print_r($comment->send_user);?></p>
<p> Оставлен комментарий к тикету <a href="<?=URL::route('ticket.show',array('id'=>$comment->ticket_id));?>"><?=$comment->ticket_id?></a></p>
<p><?=$comment->comment?></p>
