@extends('layouts.secretaire')

@section('content')
    <div class="container-fluid">
        <div class="w-100 float-right" id='calendar'></div>
    </div>
   
@endsection




@section('js')
<script>
function getRandomColor() {
  var letters = '0123456789ABCDEF';
  var color = '#';
  for (var i = 0; i < 6; i++) {
    color += letters[Math.floor(Math.random() * 16)];
  }
  return color;
}

document.addEventListener('DOMContentLoaded', function() {
  var calendarEl = document.getElementById('calendar');

  var calendar = new FullCalendar.Calendar(calendarEl, {
    googleCalendarApiKey: 'AIzaSyA6SssjS-N1lN2FqOZaZgSeg8lreQmGgoQ',
    schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
    locale:'fr',
    plugins: [ 'googleCalendar','resourceTimeline'],
    defaultView: 'resourceTimeline',
    minTime: "09:00:00",
    maxTime:"18:00:00",
    aspectRatio: 2,
    resourceAreaWidth:'10%',
    slotWidth:150,
    slotHeight:150,
 
    height: 400,
    resources: [
        @foreach($medecin as $med)
            {
                id:"{{$med->nom}}",
                title:"{{$med->nom}}",
                eventBackgroundColor:getRandomColor(),
                
            },
       @endforeach
  ],
  eventSources:[ 
    @foreach($medecin as $med)
        {
            googleCalendarId:"{{$med->gCal_id}}",
            
            eventDataTransform: function(event){
            event.resourceId = "{{$med->nom}}";
            return event;
            }
           

        },
    @endforeach
        
        
  ]
  });

  calendar.render();
});
</script>
@endsection