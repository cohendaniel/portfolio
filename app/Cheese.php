<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cheese extends Model
{
	protected $fillable = [
    	'maker','name','type','comments','image'
    ];

    function pairs() {
    	return $this->hasMany(BeerCheesePair::class);
    }
}
