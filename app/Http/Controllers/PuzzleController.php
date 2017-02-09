<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\TileMoved;
use Event;

class PuzzleController extends Controller
{
    function move(Request $request) {
    	Event::fire(new TileMoved($request->name, $request->board));
    	return $request->name;
    }
}
