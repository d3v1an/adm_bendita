<?php

class ProductProduct extends \Eloquent {
	protected $fillable = [];
	protected $table 	= 'product_product';
	public $timestamps 	= false;

	// Relacion de categoria
    public function product()
    {
        return $this->belongsTo('Product','relational_product_id');
    }
}