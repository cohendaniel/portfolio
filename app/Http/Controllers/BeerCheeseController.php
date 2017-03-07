<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\BeerCheesePair;
use App\Beer;
use App\Cheese;

class BeerCheeseController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'admin'])->except('show');
    }

    function show(BeerCheesePair $pair) {

        //get the previous pair
        $prev = BeerCheesePair::where('id', '<', $pair->id)->max('id');

        if (!(isset($prev))) {
            $prev = BeerCheesePair::max('id');
        }

        //get the next pair
        $next = BeerCheesePair::where('id', '>', $pair->id)->min('id');

        if (!(isset($next))) {
            $next = BeerCheesePair::min('id');
        }

    	return view('beercheese.show', compact('pair', 'prev', 'next'));
    }

    function update() {

        $file = fopen(base_path().'/database/beercheesedata.csv', 'r');
        
        DB::table('beers')->truncate();
        DB::table('cheeses')->truncate();
        DB::table('beer_cheese_pairs')->truncate();


        while (($data = fgetcsv($file)) !== FALSE) {

            $beer = new Beer([
                'brewery' => $data[1],
                'name' => $data[2],
                'comments' => $data[3]
            ]);

            $beer->save();

            $cheese = new Cheese([
                'maker' => $data[4],
                'name' => $data[5],
                'comments' => $data[6]
            ]);

            $cheese->save();

            $pair = new BeerCheesePair;

            $pair->beer()->associate($beer);
            $pair->cheese()->associate($cheese);
            $pair->comments = $data[7];

            $pair->save();

        }

        echo BeerCheesePair::count();
        fclose($file);

        return back();
    }

    function addBeer(Request $request) {

    	$beer = new Beer($request->all());

    	$beer->save();

    	return back();
    }

    function addCheese(Request $request) {
    	
    	$cheese = new Cheese($request->all());

    	$cheese->save();

    	return back();
    }

    function addPair(Request $request) {

    	$beer = Beer::where('name', $request->beerName)->first();
    	$cheese = Cheese::where('name', $request->cheeseName)->first();

    	$pair = new BeerCheesePair;

    	$pair->beer()->associate($beer);
    	$pair->cheese()->associate($cheese);
        $pair->comments = $request->comments;

    	$pair->save();

    	return back();
    }

    function admin() {
        $beers = Beer::all();
        $cheeses = Cheese::all();
        return view('beercheese.admin', compact('beers'), compact('cheeses'));
    }

    function index() {
        $pairs = BeerCheesePair::all();
        return view('beercheese.index', compact('pairs'));
    }
}
