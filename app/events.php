<?php
Event::listen('eloquent.created: Ticket',function(Ticket $ticket){
    $email  = $ticket->user->email;
    $admin = User::findOrFail(1);
    $adminEmail = $admin->email;
    Mail::send('emails.ticket.create',compact('ticket'),function($message) use ($email,$adminEmail){
        $message->to(array($email,$adminEmail))->subject('Создана новая задача.');
    });
});

Event::listen('eloquent.updated: Ticket',function(Ticket $ticket){
    $status='';
    $old = $ticket->getOriginal();
    if(!empty($old["price"]) && $old["price"]!=$ticket->price){
        $status ="Установлена стоимость работ";
    }
    if(!empty($old["apply"]) &&  $old["apply"]!=$ticket->apply){
        $status ="Задача одобрена клиентом";
    }
    if(!empty($old["status_id"]) &&  $old["status_id"]!=$ticket->status_id){
        $stat = Status::find($old["status_id"]);
        $status ="Статус задачи изменен с ".$stat->title." на".$ticket->status->title;
    }
    $email  = $ticket->user->email;
    $admin = User::findOrFail(1);
    $adminEmail = $admin->email;
    Mail::send('emails.ticket.update',compact('ticket','status'),function($message) use ($email,$adminEmail){
        $message->to(array($email,$adminEmail))->subject('Задача изменена.');
    });
});

Event::listen('eloquent.created: TicketComment',function(TicketComment $comment){
    $ticket = Ticket::findOrFail($comment->ticket_id);
    $email  = $ticket->user->email;
    $admin = User::findOrFail(1);
    $adminEmail = $admin->email;
    Mail::send('emails.ticket.comment',compact('comment'),function($message) use ($email,$adminEmail){
        $message->to(array($email,$adminEmail))->subject('Добавлен новый комментарий к задаче.');
    });
});
