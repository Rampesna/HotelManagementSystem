@extends('layouts.master')
@section('title', 'Konaklayanlar')
@php(setlocale(LC_ALL, 'tr_TR.UTF-8'))
@php(setlocale(LC_TIME, 'Turkish'))

@section('content')

    @include('management.stayer.components.edit_reservation_rightbar')

    @include('management.stayer.modals.edit-reservation-create-customer')
    @include('management.stayer.modals.edit-reservation-select-customer')
    @include('management.stayer.modals.add-extra-reservation')

    <button id="edit_reservation_rightbar_toggle" style="display: none"></button>
    <input type="hidden" id="selected_reservation_id">

    <div class="row">
        <div class="col-xl-12">
            <div class="card" id="reservationsCard">
                <div class="card-body">
                    <table class="table dataTable" id="reservations">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Müşteri</th>
                            <th>Firma</th>
                            <th>Geliş Tarihi</th>
                            <th>Gidiş Tarihi</th>
                            <th>Durum</th>
                            <th>Oda Türü</th>
                            <th>Pan Türü</th>
                            <th>Oda Numarası</th>
                            <th>Ücret</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Müşteri</th>
                            <th>Firma</th>
                            <th>Geliş Tarihi</th>
                            <th>Gidiş Tarihi</th>
                            <th>Durum</th>
                            <th>Oda Türü</th>
                            <th>Pan Türü</th>
                            <th>Oda Numarası</th>
                            <th>Ücret</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" id="context-menu" style="width: 300px">
        <div id="reservationEditContext">
            <a class="dropdown-item cursor-pointer">
                <div class="row">
                    <div class="col-xl-12">
                        <i class="fas fa-pen-alt text-primary"></i><span class="ml-4">Düzenle</span>
                    </div>
                </div>
            </a>
            <hr>
        </div>
        <div>
            <a class="dropdown-item cursor-pointer" data-toggle="modal" data-target="#AddExtraReservationModal">
                <div class="row">
                    <div class="col-xl-12">
                        <i class="fa fa-plus-circle text-success"></i><span class="ml-4">Ekstra Ekle</span>
                    </div>
                </div>
            </a>
        </div>
        <div style="display: none">
            <a onclick="setStatus(5)" class="dropdown-item cursor-pointer">
                <div class="row">
                    <div class="col-xl-12">
                        <i class="fa fa-stop-circle text-dark-75"></i><span class="ml-4">Konaklamayı Sonlandır</span>
                    </div>
                </div>
            </a>
        </div>
    </div>

@endsection

@section('page-styles')
    @include('management.stayer.components.style')
@stop

@section('page-script')
    @include('management.stayer.components.script')
@stop
