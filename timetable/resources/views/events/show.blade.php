@extends('layouts.timetable')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel">
                <div class="row flex-center">
                    <div class="col col-md-2 align-self-center">
                        <a class="btn" href=" {{ url('/timetable/events') }} ">Back to Events</a>
                    </div>
                    <div class="panel-heading col col-md-4 col-md-offset-2 text-center">
                        <h3 class="text-center">{{ ucfirst($event->name) }}</h3>
                    </div>
                </div>
                <div class="panel-heading"><h4 class="text-center">Slots</h4></div>
                <table class="table table-striped" id="eventTable">
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Number</th>
                    </tr>
                    <?php $row = 0 ?>
                    @foreach ($event->slots()->get() as $slot)
                        <tr id="eventRow">
                            <td id="eventRowNumber">{{ ++$row }}</td>
                            <td>{{ $slot->name }}</td>
                            <td>
                            @if ($slot->date_start == $slot->date_end)
                                {{ $slot->date_start }}
                            @else
                                {{ $slot->date_start.'-'.$slot->date_end}}
                            @endif
                            </td>
                            <td>
                            @if ($slot->time_start == $slot->time_end)
                                {{ $slot->time_start }}
                            @else
                                {{ $slot->time_start.'-'.$slot->time_end}}
                            @endif
                            </td>
                            <td>{{ $slot->number }}</td>
                        </tr>
                    @endforeach
                </table>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel">
                <div class="panel-heading"><h4 class="text-center">Items</h4></div>

                <table class="table table-striped" id="eventTable">
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Number</th>
                        <th>Edges</th>
                    </tr>
                    <?php $row = 0 ?>
                    @foreach ($items as $item)
                        <tr id="eventRow">
                            <td id="eventRowNumber">{{ ++$row }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->num_slots }}</td>
                            <td><ol>
                            @foreach ($item->edges()->get() as $edge)
                                <li>{{ $edge->slot()->get()->first()->name }}</li>
                            @endforeach
                            </ol></td>
                        </tr>
                    @endforeach
                </table>

            </div>
        </div>
    </div>
</div>
@endsection