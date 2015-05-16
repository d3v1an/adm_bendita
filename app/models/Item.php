<?php

class Item extends \Eloquent {
	protected $fillable = [];
	//public $timestamps = false;

	// Producto
    public function product()
    {
        return $this->belongsTo('Product');
    }
}