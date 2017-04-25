<?php

namespace Timetable\Http\Controllers;

use Timetable\Event;
use Timetable\Slot;
use Auth;
use DB;

use Illuminate\Http\Request;

class SlotController extends Controller
{
    /*
     * Create a new slot controller instance
     * Set connection to database and check authorization
     */
    public function __construct()
    {
        // DB::setDefaultConnection('sqlite2');
        $this->middleware('auth.timetable');
    }

    /*
     * Update slot record in database
     */
    public function update(Request $request, Slot $slot) {
        
        $slot->name = $request->name;
        $slot->date_start = $request->date_start;
        $slot->date_end = $request->date_end;
        $slot->time_start = $request->time_start;
        $slot->time_end = $request->time_end;
        $slot->number = $request->number;

        $slot->save();

        return $slot;

    }

    /*
     * Store a newly create Slot, associate with logged in user
     */
    public function store(Request $request, Event $event) {
    	
    	$slot = new Slot([
        	'name'=>$request->name,
        	'date_start'=>$request->date_start,
            'date_end'=>$request->date_end,
            'time_start'=>$request->time_start,
            'time_end'=>$request->time_end,
            'number'=>$request->number
        ]);

        $slot->user()->associate(Auth::guard('timetable')->user());
        $event->slots()->save($slot);
    }

    /*
     * Delete slot record
     */
    public function delete(Slot $slot) {
    	 $slot->delete();
    }

    /*
     * Check if user is authorized to access specific event 
     */
    private function checkUser(Event $event) {
        if (Auth::guard('timetable')->id() == $event->user_id) {
            return true;
        }
        return false;
    }
}
