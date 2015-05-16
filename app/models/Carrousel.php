<?php

class Carrousel extends \Eloquent {
	protected $fillable = [];

	// Relacion de usuario con un estado
    public function category()
    {
        //return $this->belongsTo('Category','category_id');
        return $this->belongsTo('Category');
    }
}