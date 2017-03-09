<?php

namespace Timetable\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Timetable\Event;
use Timetable\Slot;
use Timetable\Item;
use Timetable\Edge;
use Auth;
use DB;

class EventController extends Controller
{
    
    /*
     * Create a new event controller instance
     * Set connection to database and check authorization
     */
    public function __construct()
    {
        
        DB::setDefaultConnection('sqlite2');
        
        $this->middleware('auth.timetable');
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

    /*
     * Get events associated with user and return index page
     */
    public function index() {

        $events = Event::where('user_id', Auth::guard('timetable')->id())->get();
        
        return view('events.index', compact('events'));

    }

    /*
     * Get items associated with an event and return individual event page
     */
    public function show(Event $event) {
    	
        if (!$this->checkUser($event)) {
            return back();
        }
        
        $items = Item::where('event_id', $event->id)->get();
    	
        return view('events.show', compact('event', 'items'));

    }

    /*
     * Return event creation page
     */
    public function create() {
        
        return view('events.create');

    }

    /*
     * Return event edit page 
     */
    public function edit(Event $event) {

        if (!$this->checkUser($event)) {
            return back();
        }
        
        return view('events.edit', compact('event'));

    }

    /**
     * @param
     *      request: post request from event update page
     *      id: id of event to be updated
     * 
     * Update database record with new event name and return index page.
     * Note: slots are updated separately in SlotController
     */
    public function update(Request $request, $id) {

        $event = Event::where('id', $id)->first();

        if (!$this->checkUser($event)) {
            return back();
        }

        $event->name = $request->eventName;

        $event->save();

        $events = Event::where('user_id', Auth::guard('timetable')->id())->get();
        
        return view('events.index', compact('events'));

    }

    /*
     * Store newly created event and associated slots
     * Return to index page
     */
    public function store(Request $request) {
        
        $event = new Event(['name' => $request->eventName]);

        // Associate event with logged in user
        Auth::guard('timetable')->user()->events()->save($event);

        // Number of slots submitted in form
        $numSlots = count($request->slotName);
        
        for ($s = 0; $s < $numSlots; $s++) {
            
            // Form validation: slot name is not empty
            if ($request->slotName[$s]=="") 
                break;

            // Create new slot from form data
            $slot = new Slot([
                'name'=>$request->slotName[$s],
                'date'=>$request->slotDate[$s],
                'time'=>$request->slotTime[$s],
                'number'=>$request->slotNumber[$s]
            ]);

            // Associate slot with the user
            $slot->user()->associate(Auth::guard('timetable')->user());

            // Associate slot with the event
            $event->slots()->save($slot);

        }
        
        return redirect('/timetable/events');
    }

    /*
     * Delete an event
     */
    public function destroy(Event $event) {
        
        $event->delete();
        
        return back();

    }

    /*
     * Run automated scheduler given event data
     * Return index page with generated schedule displayed
     */
    public function run(Event $event) {
        
        if (!$this->checkUser($event)) {
            return back();
        }

        // Initialize event constants for automated scheduler
        $num_duplicates = Item::where('event_id', $event->id)->sum('num_slots');
        $num_items = Item::where('event_id', $event->id)->count();
        $num_blocks = Slot::where('event_id', $event->id)->count();
        $num_slots = Slot::where('event_id', $event->id)->sum('number');

        // Get slots associated with event
        $slots = Slot::select('id', 'number')->where('event_id', $event->id)->get();

        // Get the IDs of event's slots
        $slotIDs = $slots->pluck('id');

        // Select edges that have slots associated with event
        // Inner join slot and item tables
        $edges = Edge::whereIn('slot_id', $slotIDs)
                        ->join('slots', 'edges.slot_id', '=', 'slots.id')
                        ->join('items', 'edges.item_id', '=', 'items.id')
                        ->select('edges.item_id','num_slots','edges.slot_id','number')->get();

        // Create CSV files for automated scheduler
        // Make paths unique to event to avoid overwriting
        $edges_path = 'edges'.$event->id.'.csv';
        $this->createEdgeFile($edges_path, $edges);

        $slots_path = 'slots'.$event->id.'.csv';
        $this->createSlotFile($slots_path, $slots);

        // Run automated scheduler with constants and CSV files as arguments
        // Return schedule in JSON format (string)
        $data = shell_exec(base_path().'/timetable/TimeTable/timetable "'.$edges_path.'" '.$num_duplicates.' '.$num_items.' '.$num_blocks.' '.$num_slots.' "'.$slots_path.'"');

        // Delete CSV files
        unlink($edges_path);
        unlink($slots_path);

        // Format schedule into PHP friendly data structure and get names associated with ids in data
        $schedule = $this->createSchedule($data);

        return back()->with(compact('schedule'));

    }

    /*
     * Create CSV containing edge data
     */
    private function createEdgeFile($fp, $edges) {

        $f = fopen($fp, "w");

        foreach ($edges as $edge) {
            fputcsv($f, [$edge->item_id, $edge->num_slots, $edge->slot_id, $edge->number]);
        }

        fclose($f);
    }

    /*
     * Create CSV containing slot data
     */
    private function createSlotFile($fp, $slots) {

        $f = fopen($fp, "w");

        foreach ($slots as $slot) {
            fputcsv($f, [$slot->id, $slot->number]);
        }

        fclose($f);

    }

    /*
     * Take schedule as JSON string and format into associative array
     * Add names of items, slots to schedule to display to user
     */
    private function createSchedule($data) {

        $data = json_decode($data);

        // Get names of slots, items that were not matched by scheduler
        $schedule["unmatchedSlots"] = Slot::whereIn('id', $data->block_not_scheduled)->select('name')->get();
        $schedule["unmatchedItems"] = Item::whereIn('id', $data->item_not_scheduled)->select('name')->get();

        // Get names of slots and names of items matched to each slot (block)
        // e.g. Block1: Item1, Item2, ...
        foreach ($data->matched as $blockID => $itemIDs) {
            $schedule["matched"][] = ["block" => Slot::where('id', $blockID)->first(), 
                                      "items" => Item::whereIn('id', $itemIDs)->select('name')->get()];
        }

        return $schedule;

    }

}
