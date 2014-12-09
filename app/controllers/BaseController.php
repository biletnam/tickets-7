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


        Mail::send('emails.registeruser', array('email_me' => Input::get('email_me'), 'phone-me' => Input::get('phone-m'), 'message-me' => Input::get('message-me')), function($message)
        {
            $message->to('26programist@gmail.com', '')->subject('Регистрация в личном кабинете support.web-kmv.ru');
        });
    }

}
