<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\TileMoved;
use Event;
use App\SenatorNetwork;
use DB;
use App\PuzzleSolver;

class ProjectsController extends Controller
{

    function move(Request $request) {
        event(new TileMoved($request->name, $request->board));
    	return 'event sent';
    }

    function solve(Request $request) {
    	$solver = new PuzzleSolver($request->board);
    	$path = $solver->solve();
    	return $path;
    }

    function senate() {
    	$pairs = SenatorNetwork::all();
		$data = SenatorNetwork::distinct()->get(['target_id','target_name','target_party']);

		$nodes = array();
		$edges = array();

		foreach($data as $node) {
			$nodes[] = array(
				'id' => $node->target_id, 
				'title' => $node->target_name, 
				'group' => $node->target_party
			);
		}

		foreach($pairs as $edge) {
			$edges[] = array(
				"id" => $edge->source_id.$edge->target_id, 
				"to" => $edge->target_id, 
				"from" => $edge->source_id
			);
		}

		return view('projects.senate', compact('nodes', 'edges'));
	}

	function senateFriends() {
		$pairs = SenatorNetwork::all();
		$data = SenatorNetwork::distinct()->get(['target_id','target_name']);

		$nodes = array();
		$edges = array();

		foreach($data as $node) {
			$nodes[] = array('id' => $node->target_id, 'title' => $node->target_name);
		}

		foreach($pairs as $edge) {
			$edges[] = array("to" => $edge->target_id, "from" => $edge->source_id);
		}

		return view('projects.senatefriends', compact('nodes', 'edges'));
	}
}
