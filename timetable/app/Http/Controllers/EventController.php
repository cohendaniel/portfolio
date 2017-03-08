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

    public function checkUser(Event $event) {
        if (Auth::guard('timetable')->id() == $event->user_id) {
            return true;
        }
        return false;
    }

    public function index() {
        
        $events = Event::where('user_id', Auth::guard('timetable')->id())->get();
        return view('events.index', compact('events'));

    }

    public function show(Event $event) {
    	
        if (!$this->checkUser($event)) {
            return back();
        }
        $items = Item::where('event_id', $event->id)->get();
    	return view('events.show', compact('event', 'items'));

    }

    public function create() {
        
        return view('events.create');

    }

    public function edit(Event $event) {

        if (!$this->checkUser($event)) {
            return back();
        }
        return view('events.edit', compact('event'));

    }

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

    public function store(Request $request) {
        
        $event = new Event(['name' => $request->eventName]);

        Auth::guard('timetable')->user()->events()->save($event);

        $numSlots = count($request->slotName);
        
        for ($s = 0; $s < $numSlots; $s++) {
            
            if ($request->slotName[$s]=="") 
                break;

            $slot = new Slot([
                'name'=>$request->slotName[$s],
                'date'=>$request->slotDate[$s],
                'time'=>$request->slotTime[$s],
                'number'=>$request->slotNumber[$s]
            ]);

            $slot->user()->associate(Auth::guard('timetable')->user());
            $event->slots()->save($slot);

        }
        
        return redirect('/timetable/events');
    }

    public function destroy(Event $event) {
        
        $event->delete();
        return back();

    }

    public function run(Event $event) {
        
        if (!$this->checkUser($event)) {
            return back();
        }

        $slotIDs = Slot::select('id')->where('event_id', $event->id)->get();
        $slots = Slot::select('id', 'number')->where('event_id', $event->id)->get();

        $edges = Edge::whereIn('slot_id', $slotIDs)
                        ->join('slots', 'edges.slot_id', '=', 'slots.id')
                        ->join('items', 'edges.item_id', '=', 'items.id')
                        ->select('edges.item_id','num_slots','edges.slot_id','number')->get();


        $num_duplicates = Item::where('event_id', $event->id)->sum('num_slots');
        $num_items = Item::where('event_id', $event->id)->count();
        $num_blocks = Slot::where('event_id', $event->id)->count();
        $num_slots = Slot::where('event_id', $event->id)->sum('number');

        $edges_path = 'edges.csv';
        $f = fopen($edges_path, "w");

        foreach ($edges as $edge) {
            fputcsv($f, [$edge->item_id, $edge->num_slots, $edge->slot_id, $edge->number]);
        }

        fclose($f);

        $slots_path = 'slots.csv';
        $f = fopen($slots_path, "w");

        foreach ($slots as $slot) {
            fputcsv($f, [$slot->id, $slot->number]);
        }

        fclose($f);

        $data = shell_exec(base_path().'/timetable/TimeTable/timetable "'.$edges_path.'" '.$num_duplicates.' '.$num_items.' '.$num_blocks.' '.$num_slots.' "'.$slots_path.'"');

        unlink($edges_path);
        unlink($slots_path);

        $data = json_decode($data);


        $unmatchedSlots = Slot::whereIn('id', $data->block_not_scheduled)->select('name')->get();
        $unmatchedItems = Item::whereIn('id', $data->item_not_scheduled)->select('name')->get();

        $schedule["unmatchedSlots"] = $unmatchedSlots;
        $schedule["unmatchedItems"] = $unmatchedItems;

        foreach ($data->matched as $blockID => $itemIDs) {
            $schedule["matched"][] = ["block" => Slot::where('id', $blockID)->first(), 
                                      "items" => Item::whereIn('id', $itemIDs)->select('name')->get()];
        }

        return back()->with(compact('schedule'));

    }

}
