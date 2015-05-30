<?php

class Category extends \Eloquent {
	protected $fillable = [];

	// Sub categorias
    public function subs()
    {
        return $this->hasMany('SubCategory');
    }
}