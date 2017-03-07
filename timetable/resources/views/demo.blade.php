@extends('layouts.timetable')

@section('content')

<div class="container mt-xl">
    <div class="row">
        <div class="col col-md-12 text-center">
            <p class="f-lg">Create your event</p>
        </div>
        <div class="row">
            <div class="col col-md-4">
                <p class="text-center f-md">Give it a name</p>
                <p class="f-sm">Get creative. New York Cheesefest 2016, My Tutoring Schedule, Truck Deliveries? It's up to you.</p>
            </div>
            <div class="col col-md-4">
                <p class="text-center f-md">Add your slots</p>
                <p class="f-sm">Enter the dates and times of your schedule. Additionally, add the number of people or things you want to be scheduled to a specific date and time.</p>
            </div>
            <div class="col col-md-4">
                <p class="text-center f-md">Set your items</p>
                <p class="f-sm">Time (pun intended) to put in availabilities. Click on "Add Items" next to your event in order to completely fill out your schedule.</p>
            </div>
        </div>
    </div>
</div>
<div class="container bc-bold mt-xl">
    <div class="row">
        <div class="col col-md-12 text-center">
            <p class="f-lg">Run the scheduler</p>
        </div>
        <div class="row">
            <div class="col col-md-4">
                <p class="text-center f-md">Make any last edits</p>
                <p class="f-sm">Go back and edit your slots or items before you run the scheduler.</p>
            </div>
            <div class="col col-md-4">
                <p class="text-center f-md">Click run</p>
                <p class="f-sm">Your schedule will be generated. If a complete schedule could not be formed, given the item availabilities and the slots, warning messages will appear above the schedule to inform you</p>
            </div>
            <div class="col col-md-4">
                <p class="text-center f-md">Cheer</p>
                <p class="f-sm">You have a schedule.</p>
            </div>
        </div>
    </div>
</div>

@endsection