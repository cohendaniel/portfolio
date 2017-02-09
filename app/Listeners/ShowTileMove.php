<?php

namespace App\Listeners;

use App\Events\TileMoved;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ShowTileMove
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  TileMoved  $event
     * @return void
     */
    public function handle(TileMoved $event)
    {
        echo "A tile has moved.";
    }
}
