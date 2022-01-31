import { Calendar } from '@fullcalendar/core/main';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';
import interactionPlugin from '@fullcalendar/interaction'; 

var calendarEl = document.getElementById('calendar');

var date = new Date().toISOString();

let calendar = new Calendar(calendarEl, {
  plugins: [  dayGridPlugin, timeGridPlugin, listPlugin, interactionPlugin, ],
  initialView: 'dayGridMonth',
  now: date,
  nowIndicator: true,
  navLinks: true,
  selectable: true,
  unselectAuto: true,
  events: '/calendar/fetchEvent',
  editable:true,
  headerToolbar: {
    left: 'prev,next today',
    center: 'title',
    right: 'dayGridMonth,timeGridWeek,listWeek'
  }, 
  select: function(info) {
    
    $('#startEvent').html("");
    $('#titleEvent').val("")
    $('#endEvent').html("");
    var startDate = new Date(info.startStr);
    var endDate = new Date(info.endStr);
  
    $('#Modal').modal('show');

    $('#startEvent').append( startDate.toLocaleString('pl-PL'));
    $('#endEvent').append( endDate.toLocaleString('pl-PL'));

    $( "#button" ).on( "click", function() {
      $.ajax({
        type: 'POST',
        url: "/calendar/addEvent" ,
        data: {title: $('#titleEvent').val(), start: info.startStr, end: info.endStr},
        dataType: 'json', 
        
        beforeSend:function () {
            document.getElementById('loader').classList.remove('d-none');
        },
        complete:function(){
            document.getElementById('loader').classList.add('d-none');
        },
        success:function(){
               calendar.refetchEvents();
               $('#Modal').modal('hide');
               calendar.unselect();
        },
        error:function(xhr, textStatus, errorThrown){
            alert('Ajax request failed.'); 
            calendar.unselect();

        }
        })
    });
  },
  eventResize: function(event){
    $.ajax({
      type: 'POST',
      url: "/calendar/updateEvent" ,
      data: {start: event.event.startStr, end: event.event.endStr, id: event.event.id},
      dataType: 'json', 
      success:function(){
             calendar.refetchEvents();
      },
      error:function(xhr, textStatus, errorThrown){
          alert('Ajax request failed.'); 
      }
    })
  },
  eventDrop: function(event){
    $.ajax({
      type: 'POST',
      url: "/calendar/updateEvent" ,
      data: {start: event.event.startStr, end: event.event.endStr, id: event.event.id},
      dataType: 'json', 
      success:function(){
             calendar.refetchEvents();
      },
      error:function(xhr, textStatus, errorThrown){
          alert('Ajax request failed.'); 
      }
    })
  },
  eventClick:function(event){
    if(confirm("Czy na pewno chcesz usunąć wydarzenie?")){
      $.ajax({
        type: 'POST',
        url: "/calendar/deleteEvent" ,
        data: {id: event.event.id},
        dataType: 'json', 
        success:function(){
               calendar.refetchEvents();
        },
        error:function(xhr, textStatus, errorThrown){
            alert('Ajax request failed.'); 
        }
      })
    }
  }
});

calendar.render();

