<p>Отправлено от: <? print_r($ticket->send_user);?></p>
<p> На сайте создан тикет №<a href="<?=URL::route('ticket.show',array('id'=>$ticket->id));?>"><?=$ticket->id?></a></p>

