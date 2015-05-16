<?php

class User extends Eloquent {
	protected $fillable = [];

	// Relacion a interes dle usuario
    public function interest()
    {
        return $this->belongsTo('Interest');
    }

    // Pais de origen
    public function country()
    {
        return $this->belongsTo('Country');
    }

    // Estado
    public function state()
    {
        return $this->belongsTo('State');
    }

    // Nivel
    public function level()
    {
        return $this->belongsTo('Level');
    }

    // Tipo
    public function type()
    {
        return $this->belongsTo('Type');
    }

    // Pais de facturacion
    public function df_country()
    {
        return $this->belongsTo('Country','df_country_id');
    }

    // Estado de facturacion
    public function df_state()
    {
        return $this->belongsTo('State','df_state_id');
    }

    // Pais de envio
    public function de_country()
    {
        return $this->belongsTo('Country','de_country_id');
    }

    // Estado de envio
    public function de_state()
    {
        return $this->belongsTo('State','de_state_id');
    }

    // contenido de carrito
    public function cart()
    {
        return $this->belongsToMany('Cart');
    }
}
