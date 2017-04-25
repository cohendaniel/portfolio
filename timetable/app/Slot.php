<?php

namespace Timetable;

use Illuminate\Database\Eloquent\Model;

class Slot extends Model
{
    protected $connection = 'sqlite2';
    protected $fillable = [
        'name', 'date_start', 'time_start', 'date_end', 'time_end', 'number'
    ];

    function item() {
    	return $this->belongsTo(Item::class);
    }

    function user() {
    	return $this->belongsTo(User::class);
    }

    function event() {
    	return $this->belongsTo(Event::class);
    }

    function edges() {
        return $this->hasMany(Edge::class);
    }
}
