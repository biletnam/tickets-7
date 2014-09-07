<?php
Event::listen('eloquent.created: Ticket',function(Ticket $ticket){
    /*Mail::send('emails.ticket.create',compact('ticket'),function($message){
        $message->to(array('alexeev.sker@gmail.com'))->subject('Ticket create!');
    });*/
});
