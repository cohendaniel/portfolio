<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BeerCheesePair extends Model
{

	protected $fillable = ['comments'];

    function beer() {
    	return $this->belongsTo(Beer::class);
    }

    function cheese() {
    	return $this->belongsTo(Cheese::class);
    }
}
