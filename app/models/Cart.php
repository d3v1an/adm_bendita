<?php

class Cart extends \Eloquent {
	protected $fillable = [];

	// Usuario propietario del carrito
    public function user()
    {
        return $this->belongsTo('User');
    }

    // Producto relacionado con el carrito
    public function product()
    {
        return $this->belongsTo('Product');
    }
}