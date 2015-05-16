<?php

class SubCategory extends \Eloquent {
	protected $fillable = [];
	public $timestamps = false;

	// Relacion de categoria
    public function category()
    {
        return $this->belongsTo('Category');
    }
}