<?php

namespace Timetable;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $connection = 'sqlite2';
    protected $fillable = [
        'name', 'num_slots'
    ];

    // get the slots that the item is fulfilling
    function slots() {
    	return $this->hasMany(Slot::class);
    }

    // get the availability of the item
    function edges() {
    	return $this->hasMany(Edge::class);
    }

    function user() {
    	return $this->belongsTo(User::class);
    }

    function event() {
    	return $this->belongsTo(Event::class);
    }

}
