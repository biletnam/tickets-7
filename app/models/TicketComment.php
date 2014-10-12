<?
class TicketComment extends \Eloquent {
    protected $guarded = array('_token');
    protected $table = 'ticket_comments';

    public function user()
    {
        return $this->belongsTo('User')->select('full_name','email')->remember(10);
    }
}