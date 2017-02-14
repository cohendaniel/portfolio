<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SenatorNetwork extends Model
{
    protected $fillable = [
    	'source_id', 'source_name', 'source_handle', 'source_party', 'source_state', 'target_id', 'target_name', 'target_handle', 'target_party', 'target_state'
    ];
}
