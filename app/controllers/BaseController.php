<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}
    public function homepagesend()
    {

        Mail::send('emails.registeruser', array('email_me' => Input::get('email-me'), 'phone_me' => Input::get('phone-me'), 'message_me' => Input::get('message-me')), function($message)
        {
            $message->to('webkmv26@gmail.com', '')->subject('Регистрация в личном кабинете support.web-kmv.ru');
        });
    }

}
