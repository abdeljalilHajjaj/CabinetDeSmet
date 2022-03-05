@extends('layouts.medecin')


@section('content')
    <div style="width: 100vw;float: right;"id="calendar"></div>
@endsection

@section('js')
<script>

    document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        googleCalendarApiKey: 'AIzaSyA6SssjS-N1lN2FqOZaZgSeg8lreQmGgoQ',
        locale: 'fr',
        plugins: [ 'dayGrid','timeGrid','googleCalendar' ],
        defaultView: 'timeGridWeek',
        allDaySlot: false,
        hiddenDays: [ 0, 6 ],
        minTime: "09:00:00",
        maxTime:"18:00:00",
        header:{
        left:   'title dayGrid timeGrid timeGridWeek',
            center: '',
            right:  'today prev,next'
        },
        height: 400,
        
        

        events: {
            googleCalendarId: "{{Auth::guard('medecin')->user()->gCal_id}}",
            className: 'nice-event',
            color:'green',

        },
    });

    calendar.render();
    });


</script>
@endsection