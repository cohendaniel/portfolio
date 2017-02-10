<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\TileMoved;
use Event;

class PuzzleController extends Controller
{
    function move(Request $request) {
        event(new TileMoved($request->name, $request->board));
    	return 'event sent';
    }
}
