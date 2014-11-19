<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;
    use SoftDeletingTrait;

    protected $dates = ['deleted_at'];

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

    protected $guarded = array('password_confirmation');

    public function scopeUserList($query){

        if(Input::get('id')){
            $query->where('id','=',Input::get('id'));
        }

        if(Input::get('full_name')){
            $query->where('full_name','like',"%".Input::get('full_name')."%");
        }

        if(Input::get('email')){
            $query->where('email','like',"%".Input::get('email')."%");
        }

        if(Input::get('role',false)){
            $query->where('role','=',Input::get('role'));
        }

        if(Input::get('phone')){
            $query->where('phone','like',"%".Input::get('phone')."%");
        }

        $query->orderBy('created_at','desc');
    }
}
