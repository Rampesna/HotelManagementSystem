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

    .dynamic-column {
        -ms-flex: 0 0 {{ 100 / count($roomUseTypes) }}%;
        flex: 0 0 {{ 100 / count($roomUseTypes) }}%;
        max-width: {{ 100 / count($roomUseTypes) }}%;
        position: relative;
        padding-right: 4px;
        padding-left: 4px;
        margin-top: 0;
    }
</style>
