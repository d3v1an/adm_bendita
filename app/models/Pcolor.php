<?php

class Pcolor extends \Eloquent {
	protected $fillable = [];
	protected $table 	= 'pcolors';

	public $timestamps 	= false;

	// Color principal
    public function color()
    {
        return $this->belongsTo("Color");
    }

    // Producto
    public function product()
    {
        return $this->belongsTo("Product");
    }
}