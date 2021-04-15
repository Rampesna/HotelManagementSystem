<link href="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css?v=7.0.3') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css?v=7.0.3') }}" rel="stylesheet" type="text/css"/>

<style>
    .offcanvas.offcanvas-right {
        right: -800px;
        left: auto
    }

    .fc-day:hover{
        background: lightgrey;
    }

    /*Allow pointer-events through*/
    .fc-slats, /*horizontals*/
    .fc-content-skeleton, /*day numbers*/
    .fc-bgevent-skeleton /*events container*/{
        pointer-events:none
    }

    /*Turn pointer events back on*/
    .fc-bgevent,
    .fc-event-container{
        pointer-events:auto; /*events*/
    }
</style>
