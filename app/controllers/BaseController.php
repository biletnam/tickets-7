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
        Mail::send('emails.registeruser', array('key' => 'value'), function($message)
        {
            $message->to('foo@example.com', 'John Smith')->subject('Welcome!');
        });
    }

}
