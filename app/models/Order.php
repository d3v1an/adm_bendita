<?php

class Order extends \Eloquent {
	protected $fillable = [];

	// Usuario
    public function user()
    {
        return $this->belongsTo('User');
    }

    // Admin
    public function admin()
    {
        return $this->belongsTo('Admin');
    }

    // Paqueteria
    public function parcel()
    {
        return $this->belongsTo('Parcel');
    }

    // Tipo de pago
    public function payment_type()
    {
        return $this->belongsTo('PaymentType');
    }

    // Estatus de orden
    public function status()
    {
        return $this->belongsTo('Status');
    }

    // Items
    public function items()
    {
        return $this->belongsToMany('Item');
    }

    // Notas
    public function notes()
    {
        return $this->hasMany('Note');
    }

}