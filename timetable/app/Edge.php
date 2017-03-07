<?php

namespace Timetable;

use Illuminate\Database\Eloquent\Model;

class Edge extends Model
{

	protected $hidden = [
        'updated_at', 'created_at'
    ];

	function item() {
    	return $this->belongsTo(Item::class);
    }

    function slot() {
    	return $this->belongsTo(Slot::class);
    }

}
