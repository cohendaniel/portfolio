@extends('layouts.timetable')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel">
                <div class="row flex-center">
                    <div class="col col-md-2 align-self-center">
                        <a class="btn" href=" {{ url('/timetable/events') }} ">Back to Events</a>
                    </div>
                    <div class="col col-md-4 col-md-offset-2 text-center">
                        <h2>{{ $event->name }}</h2>
                    </div>
                </div>
                <form method="post" action=" {{ url('timetable/events/update', $event->id) }} ">
                    {{ method_field('PUT')}}
                    <input type="hidden", name="eventID" id="eventID" value="{{ $event->id }}" >
                    <!-- <div class="row text-center">
                        <input type="text" name="eventName" value='{{ $event->name }}' class="text-center mx-50">
                        <input type="submit" value="Update" class="btn col-md-2 col-md-offset-1">
                    </div> -->
                    <table class="table table-striped" id="eventTable">
                        <tr>
                            <th></th>
                            <th>Name</th>
                            <th>Start Date</th>
                            <th>Start Time</th>
                            <th>End Date</th>
                            <th>End Time</th>
                            <th>Number</th>
                            <th></th>
                            <th></th>
                        </tr>
                        <?php $row = 0 ?>
                        @foreach ($event->slots()->get() as $slot)
                            <tr id="eventRow">
                                <input type="hidden", name="slotID" value="{{ $slot->id }}" >
                                <td id="eventRowNumber">{{ ++$row }}</td>
                                <td><input type="text" name="slotName[]" value="{{ $slot->name }}" disabled></td>
                                <td><input type="date" name="slotDateStart[]" value="{{ $slot->date_start }}" disabled></td>
                                <td><input type="time" name="slotTimeStart[]" value="{{ $slot->time_start }}" disabled></td>
                                <td><input type="date" name="slotDateStart[]" value="{{ $slot->date_end }}" disabled></td>
                                <td><input type="time" name="slotTimeStart[]" value="{{ $slot->time_end }}" disabled></td>
                                <td><input type="text" name="slotNumber[]" value="{{ $slot->number }}" disabled></td>
                                <td><input type="button" value="Edit" class="editsave btn btn-2"></td>
                                <td><input type="button" value="Delete" class="delete btn btn-3"></td>
                            </tr>
                        @endforeach
                    </table>
                </form>

            </div>
            <div class="row text-center">
                <button class="btn btn-lg btn-1" onclick="addRow()">Add row</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
<script type="text/javascript">
    
    $(document).ready(function() {
        
        $('#eventTable').on('click', '.delete', function() {
            var row = $(this).parent();
            var slotID = row.prevAll('input').val();
            $.ajax({
                url: "/timetable/slots/" + slotID,
                type: "DELETE",
                success: function() {
                    row.parent().remove();
                }
            });
        });

        $('#eventTable').on('click', '.editsave', function() {
            
            $(this).parent().prevAll().children().prop("disabled", function() {
                return !($(this).prop("disabled"));
            });

            $(this).toggleClass('btn-1 btn-2');

            if ($(this).hasClass('new btn-2')) {
                $(this).val("Edit");
                var row = $(this).parent();
                var slot = row.prevAll().children('input');
                var eventID = $('#eventID').val();
                $.post("/timetable/events/"+eventID+"/slot", 
                    {
                        name: slot.eq(5).val(),
                        date_start: slot.eq(4).val(),
                        time_start: slot.eq(3).val(),
                        date_end: slot.eq(2).val(),
                        time_end: slot.eq(1).val(),
                        number: slot.eq(0).val()
                    }, function(data) {
                        console.log('new');
                        row.children('input').removeClass('new');
                    });
            }

            else if ($(this).hasClass('btn-2')) {
                $(this).val("Edit");
                var slot = $(this).parent().prevAll().children('input');
                var slotID = $(this).parent().prevAll('input').val();
                $.post("/timetable/slots/"+slotID+"/update", 
                    {
                        name: slot.eq(5).val(),
                        date_start: slot.eq(4).val(),
                        time_start: slot.eq(3).val(),
                        date_end: slot.eq(2).val(),
                        time_end: slot.eq(1).val(),
                        number: slot.eq(0).val()
                    }, function(data) {
                        console.log('update');
                        console.log(data);
                    });
            }

            else {
                $(this).val("Save");
            }
        });
    })


    function addRow() {
        var $clone = $('#eventTable').find('tr').last().clone();
        
        var $inputs = $clone.find('input[type=text], input[type=date], input[type=time]').val('');
        
        $clone.find('input[type=button]').addClass('new');

        var $lastNum = parseInt($clone.find('#eventRowNumber').html());
        $clone.find('#eventRowNumber').html($lastNum + 1);
        
        $clone.appendTo('#eventTable');
    }
</script>
@endsection