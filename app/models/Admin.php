<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Admin extends \Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'admins';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token','admins_level_id');

	// Relacion de usuario con un estado
    public function level()
    {
        return $this->belongsTo('AdminsLevel','admins_level_id');
    }

    public function getRememberToken()
    {   
    	return $this->remember_token;
    }

    public function setRememberToken($value)
    {
    	$this->remember_token = $value;
    }   

    public function getRememberTokenName()
    {
    	return 'remember_token';
    }
}