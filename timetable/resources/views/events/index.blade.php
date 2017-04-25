@extends('layouts.timetable')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel">
                <div class="panel-heading flex-center row">
                    <div class="col col-md-6 col-md-offset-3 text-center panel-title">Events</div>
                    <div class="col col-md-3 align-self-center"><a href="{{ url('/timetable/events/create') }}" class="btn">Create event</a></div>
                </div>

                <div class="panel-body">
                    <table class="table">
                    @if (count($events) == 0)
                        <div class="panel text-center bc-bold">
                            <h2>No events to show. Create one now!</h2>
                        </div>
                    @endif
                    @foreach ($events as $event)
                        <tr>
                            <td><a href='/timetable/events/{{$event->id}}'><strong>{{ ucfirst($event->name) }}</strong></a></td>
                            <td><a href='/timetable/events/{{$event->id}}/items/create' class="btn btn-1">Add items</a></td>
                            <td>
                                <form action=" {{ url('/timetable/events/'.$event->id.'/run') }}" method="post">
                                    {{ method_field('GET') }}
                                    <input type="submit" value="Run" id="run" class="btn btn-1">
                                </form>
                            </td>
                            <td>
                                <form action=" {{ url('/timetable/events/'.$event->id.'/edit') }}" method="post">
                                    {{ method_field('GET') }}
                                    <input type="submit" value="Edit" class="btn btn-2">
                                </form>
                            </td>
                            <td>
                                <form action=" {{ url('/timetable/events/'.$event->id) }}" method="post">
                                    {{ method_field('DELETE') }}
                                    <input type="submit" value="Delete" class="btn btn-3">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </table>
                </div>
                @if (session('schedule'))
                    <div class="panel-body">
                    @if (count(session('schedule')['unmatchedSlots']) != 0)
                        <div id="errors">
                            Block warnings
                            <ul>
                                @foreach(session('schedule')['unmatchedSlots'] as $block)
                                    <li><b>{{ $block->name }}</b> is not fully scheduled </li>
                                @endforeach
                            </ul>
                    @endif
                    @if (count(session('schedule')['unmatchedItems']) != 0)
                            Item warnings
                            <ul>
                                @foreach(session('schedule')['unmatchedItems'] as $item)
                                    <li><b>{{ $item->name }}</b> is not scheduled </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                        <table class="table-center table-striped">
                            <tr>
                                <th>Slots</th>
                                <th>Items</th>
                                <th></th>
                            </tr>
                            @if (isset(session('schedule')['matched']))
                                @foreach (session('schedule')['matched'] as $match)
                                    <tr>
                                        <td>{{ $match['block']['name'] }}</td>
                                        <td>
                                            <ol>
                                            @foreach ($match['items'] as $item)
                                                <li>{{ $item['name'] }}</li>
                                            @endforeach
                                            </ol>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <h3 class="text-center bc-bold">No matches found.</h3>
                            @endif
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')

<script type="text/javascript">

</script>

@endsection
