<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Beer extends Model
{
    protected $fillable = [
    	'brewery','name','type','comments','image'
    ];

    function pairs() {
    	return $this->hasMany(BeerCheesePair::class);
    }
}
