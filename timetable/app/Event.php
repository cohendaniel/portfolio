<?php

namespace Timetable;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
	protected $connection = 'sqlite2';
	protected $fillable = ['name'];

    function user() {
    	return $this->belongsTo(User::class);
    }

    function slots() {
    	return $this->hasMany(Slot::class);
    }

}
