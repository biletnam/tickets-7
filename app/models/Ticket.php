<?php

class Ticket extends \Eloquent {
    protected $guarded = array('_token');
    protected $errors;

    protected $createRules = [
        'url'=>'required',
        'title'=>'required',
        'priority_id'=>'required',
        'file_path'=>'size:8'
    ];

    public function validateCreate($data)
    {
        // make a new validator object
        $v = Validator::make($data, $this->createRules);

        if ($v->fails())
        {
            // set errors and return false
            $this->errors = $v->errors();
            return false;
        }

        // validation pass
        return true;
    }

    public function errors()
    {
        return $this->errors;
    }
}