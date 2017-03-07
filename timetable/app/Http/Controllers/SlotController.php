<?php

namespace Timetable\Http\Controllers;

use Timetable\Event;
use Timetable\Slot;
use Auth;
use DB;

use Illuminate\Http\Request;

class SlotController extends Controller
{
    public function __construct()
    {
        DB::setDefaultConnection('sqlite2');
        $this->middleware('auth.timetable');
    }

    public function update(Request $request, Slot $slot) {
        
        $slot->name = $request->name;
        $slot->date = $request->date;
        $slot->time = $request->time;
        $slot->number = $request->number;

        $slot->save();

        print_r($slot);
        return $slot;

    }

    public function store(Request $request, Event $event) {
    	
    	$slot = new Slot([
        	'name'=>$request->name,
        	'date'=>$request->date,
            'time'=>$request->time,
            'number'=>$request->number
        ]);

        $slot->user()->associate(Auth::guard('timetable')->user());
        $event->slots()->save($slot);
    }

    public function delete(Slot $slot) {
    	 $slot->delete();
    }

    public function checkUser(Event $event) {
        if (Auth::guard('timetable')->id() == $event->user_id) {
            return true;
        }
        return false;
    }
}
