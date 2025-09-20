@extends('layouts.admin')

@section('title','Usuarios · '.config('app.name'))

@section('content')

<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" rel="stylesheet">
<style>
  body {
    font-family: system-ui, -apple-system, Segoe UI, Roboto, sans-serif;
    margin: 0;
    background: #f8fafc;
    color: #111827
  }



  .title {
    font-size: 22px;
    font-weight: 800;
    margin: 0 0 8px
  }

  .muted {
    color: #6b7280;
    margin: 0 0 16px
  }

  #calendar {
    background: #fff;
    border-radius: 12px;
    overflow: hidden
  }

  .legend {
    display: flex;
    gap: 12px;
    margin-bottom: 12px;
    align-items: center;
    flex-wrap: wrap
  }

  .chip {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 10px;
    border: 1px solid #e5e7eb;
    border-radius: 999px;
    font-size: 13px;
    background: #fff
  }

  .dot {
    width: 10px;
    height: 10px;
    border-radius: 999px;
    display: inline-block
  }

  .dot-pending {
    background: #f59e0b
  }

  .dot-confirmed {
    background: #10b981
  }

  .dot-cancelled {
    background: #ef4444
  }
</style>
</head>


<div class="card mt-0 p-3">
  <h1 class="title">Calendario de Reservas</h1>
  <p class="muted">Visualiza todas las citas registradas por propiedad e interesado.</p>

  <div class="legend">
    <span class="chip"><span class="dot dot-pending"></span> Pendiente</span>
    <span class="chip"><span class="dot dot-confirmed"></span> Confirmada</span>
    <span class="chip"><span class="dot dot-cancelled"></span> Cancelada</span>
  </div>

  <div id="calendar"></div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const calEl = document.getElementById('calendar');
    const calendar = new FullCalendar.Calendar(calEl, {
      initialView: 'dayGridMonth',
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
      },
      slotMinTime: '07:00:00',
      slotMaxTime: '20:00:00',
      navLinks: true,
      nowIndicator: true,
      editable: false,
      eventSources: [{
        url: '<?php echo route('reservations.events.list') ?>',
        method: 'GET',
        failure: () => alert('No se pudieron cargar los eventos'),
      }],

      eventClick: function(info) {
        // redirige a la ruta de detalle
        window.location.href = "<?php echo route('reservations.showEvent') ?>?id=" + info.event.id;
      },

      eventDidMount: function(info) {
        const status = info.event.extendedProps?.status;
        const bg = {
          'pending': '#f59e0b',
          'confirmed': '#10b981',
          'cancelled': '#ef4444'
        } [status] || '#3b82f6';
        info.el.style.backgroundColor = bg;
        info.el.style.borderColor = bg;
        info.el.style.color = '#fff';
        info.el.style.fontWeight = '600';
      },
      eventTimeFormat: {
        hour: '2-digit',
        minute: '2-digit',
        hour12: false
      },
      locale: 'es'
    });
    calendar.render();
  });
</script>

@endsection