@extends('layouts.timetable')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <form style="margin-bottom: 0px" method="post" action=" {{ url('/timetable/events') }} ">
                    <div class="panel-heading text-center"><input type="text" placeholder="Event name" name="eventName"></div>
                    <table class="table table-striped" id="eventTable">
                        <tr>
                            <th></th>
                            <th>Name</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Number</th>
                        </tr>
                        @for ($row = 1; $row <= 5; $row++)
                            <tr id="eventRow">
                                <td id="eventRowNumber">{{ $row }}</td>
                                <td><input type="text" name="slotName[]"></td>
                                <td><input type="date" name="slotDate[]"></td>
                                <td><input type="time" name="slotTime[]"></td>
                                <td><input type="text" name="slotNumber[]"></td>
                            </tr>
                        @endfor
                    </table>
                    
                    <div class="text-center"><button type="button" class="btn" onclick="addRow()">Add row</button></div>
               
                    <div class="panel-footer text-center">
                        <input class="btn btn-primary btn-block" type="submit">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

<script type="text/javascript">
    function addRow() {
        var $clone = $('#eventTable').find('tr').last().clone();
        
        var $inputs = $clone.find('input').val('');
        
        var $lastNum = parseInt($clone.find('#eventRowNumber').html());
        $clone.find('#eventRowNumber').html($lastNum + 1);
        
        $clone.appendTo('#eventTable');
    }
</script>