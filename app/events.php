<?php
Event::listen('eloquent.created: Ticket',function(Ticket $ticket){
    $email  = $ticket->user->email;
    $admin = User::findOrFail(1);
    $adminEmail = $admin->email;
    $ticket->send_user = Auth::user()->full_name;
    Mail::send('emails.ticket.create',compact('ticket'),function($message) use ($email,$adminEmail){
        $message->to(array($email,$adminEmail))->subject('Создана новая задача.');
    });
});

Event::listen('eloquent.updated: Ticket',function(Ticket $ticket){
    $ticket->send_user = Auth::user()->full_name;
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

// Dobavlenie ispolnitelya
Event::listen('eloquent.updated: Ticket',function(Ticket $ticket){
    $ticket->send_user = Auth::user()->full_name;
    $status='';
    $old = $ticket->getOriginal();
    if(!empty($old["worker"]) && $old["worker"]!=$ticket->worker){
        $status ="izmenenya v spiske ispolniteley";
    } else {
        $status ="";
    }

    $worker_array = $ticket->worker;
    $worker_array = str_replace('[',"",$worker_array);
    $worker_array = str_replace(']',"",$worker_array);
    $ticket->worker_array = $worker_array;

    if($ticket->worker_array) {
        $ticket->results_me = DB::select('select email from users where id IN ('.$ticket->worker_array.')');
        $datas = array();
        foreach ($ticket->results_me as $key => $value) {
            $datas[] = $value->email;
        }
        if(!empty($old["worker"]) && $old["worker"]!=$ticket->worker){
            $status ="izmenenya v spiske ispolniteley";
        }

        if(!empty($old["worker"]) && $old["worker"]!=$ticket->worker){
            Mail::send('emails.ticket.new_worker',compact('ticket','status'),function($message) use ($datas, $status) {
                $message->to($datas)->subject("Добавлен исполнитель к задаче");
            });
        }
    }


});


Event::listen('eloquent.created: TicketComment',function(TicketComment $comment){
    $comment->send_user = Auth::user()->full_name;
    $ticket = Ticket::findOrFail($comment->ticket_id);
    $email  = $ticket->user->email;
    $admin = User::findOrFail(1);
    $adminEmail = $admin->email;
    Mail::send('emails.ticket.comment',compact('comment'),function($message) use ($email,$adminEmail){
        $message->to(array($email,$adminEmail))->subject('Добавлен новый комментарий к задаче.');
    });
});
