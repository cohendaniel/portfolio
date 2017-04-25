@extends('layouts.timetable')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel">
                <div class="row flex-center">
                    <div class="btn col col-md-2 align-self-center">
                        <a href=" {{ url('\timetable\events') }} ">Back to Events</a>
                    </div>
                    <div class="col col-md-4 col-md-offset-2 panel-heading text-center"><h3>Create Item</h3></div>
                </div>
                <form method="post" action=" {{ url('/timetable/events/'.$event->id.'/items') }} ">
                    <label>Name: </label><input type="text" name="itemName" class="mx-xs">
                    <label>Number: </label><input type="text" name="itemNumber" class="mx-xs">
                    <table class="table table-striped mt-xs" id="itemTable">
                        <tr>
                            <th></th>
                            <th>Slot name</th>
                            <th>Date</th>
                            <th>Time</th>
                        </tr>
                        @foreach($slots as $slot)
                        <tr id="itemRow">
                            <td><input type="checkbox" name="itemCheckBox[]" value="{{ $slot->id }}" class="checkbox"></td>
                            <td><strong>{{ $slot->name }}</strong></td>
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
                        </tr>
                        @endforeach
                    </table>
                    <div class="text-center"><input type="submit" value="Submit" class="btn"></div>
                </form>
            </div>
            {{ session('message') }}
        </div>
    </div>
</div>
@endsection