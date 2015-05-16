<?php

class Note extends \Eloquent {
	protected $fillable = [];

	// Orden
    public function order()
    {
        return $this->belongsTo('Order');
    }

    // Replicas
    public function reply()
    {
        return $this->hasOne('Reply');
    }

    // Usuario
    public function user()
    {
        return $this->belongsTo('User');
    }
}