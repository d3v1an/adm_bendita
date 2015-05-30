<?php

class Product extends \Eloquent {
	protected $fillable = [];

	// Relacion de categoria
    public function category()
    {
        return $this->belongsTo('Category');
    }

    // Relacion de sub categoria
    public function sub_category()
    {
        return $this->belongsTo('SubCategory');
    }

    // Sub categorias
    public function sub_categories()
    {
        return $this->belongsToMany('SubCategory');
    }

    // Colores
    public function colors()
    {
        return $this->belongsToMany('Color');
    }

    // Materiales
    public function materials()
    {
        return $this->belongsToMany('Material');
    }

    // Imagen principal
    public function image()
    {
        return $this->hasOne("Image");
    }

    // Galeria
    public function galery()
    {
        return $this->hasMany("Galery");
    }

    // Tallas
    public function sizes()
    {
        return $this->belongsToMany('Size');
    }

    // Tallas
    public function products()
    {
        return $this->hasMany('ProductProduct');
    }

    // Link
    public function link()
    {
        return $this->hasOne("Link");
    }

    // Pcolors
    public function link_colors()
    {
        return $this->belongsToMany('Pcolor');
    }
}