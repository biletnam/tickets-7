<p>Отправлено от: <? print_r($ticket->send_user);?></p>
<p>Тикет №<a href="<?=URL::route('ticket.show',array('id'=>$ticket->id));?>"><?=$ticket->id?></a> был изменен</p>
<?if(!empty($status)){?>
    <p><?=$status?></p>
<?}?>

