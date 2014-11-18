/*
 * SimpleModal Basic Modal Dialog
 * http://simplemodal.com
 *
 * Copyright (c) 2013 Eric Martin - http://ericmmartin.com
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 */

jQuery(function ($) {
	// Load dialog on page load
	//$('#basic-modal-content').modal();

	// Load dialog on click
	$('#basic-modal .basic').click(function (e) {
		$('#basic-modal-content').modal();

		return false;
	});

    $('#commentForm').submit(function(e){
        e.preventDefault();
        self = $(this);
        var obj ={};
        obj.comment = $(this).find('[name="comment"]').val();
        obj.ticket_id = $(this).find('[name="ticket_id"]').val();
        obj._token = $(this).find('[name="_token"]').val();
        obj._method = "post";
        if (obj.comment.trim().length==0) return alert('Введите комментраий');
        jQuery.ajax({
            type:"post",
            url:self.attr('href'),
            data:obj,
            success: function(data){
                    try{
                        if(data =  JSON.parse(data)){
                            /*self.html('Комментарий оставлен.');*/
                            $(".white-bock").append('<div class="section"><img alt="" src="/images/pic1.jpg"><h5>Ваше сообщение</h5><p>'+data.comment+'</p><span class="time">'+data.created_at+'</span></div>');
                            $(".white-bock").animate({"scrollTop": $('.white-bock')[0].scrollHeight}, "slow");
                            $('.comment-error').html('Комментарий оставлен.');
                        }
                    }catch(ex){
                        consol.log(ex);
                    }
                }
            }
        )
    })
});

