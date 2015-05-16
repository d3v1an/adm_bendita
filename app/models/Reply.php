<?php

class Reply extends \Eloquent {
	protected $fillable = [];

	// Administrador
    public function admin()
    {
        return $this->belongsTo('Admin');
    }
}