<?php

class SubCategory extends \Eloquent {
	protected $fillable = [];
	public $timestamps = false;
	public $table = 'sub_categories';

	// Relacion de categoria
    public function category()
    {
        return $this->belongsTo('Category');
    }
}