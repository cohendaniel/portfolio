<?php

namespace Timetable\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Timetable\Event;
use Timetable\Slot;
use Timetable\Item;
use Timetable\Edge;
use Auth;
use DB;

class ItemController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        DB::setDefaultConnection('sqlite2');
        $this->middleware('auth.timetable');
    }

    public function create(Event $event) {
        if (!$this->checkUser($event)) {
            return back();
        }
        $slots = Slot::where('event_id', $event->id)->get();
        return view('items.create', compact('slots', 'event'));
    }

    public function store(Request $request, Event $event) {
        
        if (!$this->checkUser($event)) {
            return back();
        }
        $item = new Item([
            'name' => $request->itemName,
            'num_slots' => $request->itemNumber
        ]);


        $item->event()->associate($event);
        $item->user()->associate($event->user_id);

        $item->save();

        foreach ($request->itemCheckBox as $slotId) {
            $slot = Slot::find($slotId);

            $edge = new Edge;
            $edge->slot()->associate($slot);
            $edge->item()->associate($item);

            $edge->save();

        }

        return back()->with('message', 'Item accepted!');
    }

    public function checkUser(Event $event) {
        if (Auth::guard('timetable')->id() == $event->user_id) {
            return true;
        }
        return false;
    }
}
