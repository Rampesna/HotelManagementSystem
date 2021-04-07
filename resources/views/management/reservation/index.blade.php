@extends('layouts.master')
@section('title', 'Rezervasyonlar')
@php(setlocale(LC_ALL, 'tr_TR.UTF-8'))
@php(setlocale(LC_TIME, 'Turkish'))

@section('content')

    @include('management.reservation.components.create_reservation_rightbar')
    @include('management.reservation.components.edit_reservation_rightbar')

    @include('management.reservation.modals.create-customer')
    @include('management.reservation.modals.select-customer')

    @include('management.reservation.modals.edit-reservation-create-customer')
    @include('management.reservation.modals.edit-reservation-select-customer')

    <button id="edit_reservation_rightbar_toggle" style="display: none"></button>
    <div class="row">
        <div class="col-xl-12">
            <button id="create_reservation_rightbar_toggle" class="btn btn-primary">Yeni Rezervasyon Oluştur</button>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-xl-12">
            <div class="card" id="reservationsCard">
                <div class="card-body">
                    <table class="table dataTable" id="reservations">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Müşteri</th>
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
        <div id="editable-context-menu">
            <a class="dropdown-item" id="editReservationContext">
                <div class="row">
                    <div class="col-xl-12 cursor-pointer">
                        <i class="fa fa-edit text-dark-75"></i><span class="ml-4">Düzenle</span>
                    </div>
                </div>
            </a>
            <hr>
        </div>
        <a onclick="setWaiting()" class="dropdown-item">
            <div class="row">
                <div class="col-xl-12 cursor-pointer">
                    <i class="fas fa-clock text-warning"></i><span class="ml-4">Seçilenleri Beklemeye Al</span>
                </div>
            </div>
        </a>
        <a onclick="approve()" class="dropdown-item">
            <div class="row">
                <div class="col-xl-12 cursor-pointer">
                    <i class="fas fa-check text-success"></i><span class="ml-4">Seçilenleri Onayla</span>
                </div>
            </div>
        </a>
        <a onclick="deny()" class="dropdown-item">
            <div class="row">
                <div class="col-xl-12 cursor-pointer">
                    <i class="fas fa-times text-danger"></i><span class="ml-4">Seçilenleri İptal Et</span>
                </div>
            </div>
        </a>
    </div>

@endsection

@section('page-styles')
    @include('management.reservation.components.style')
@stop

@section('page-script')
    @include('management.reservation.components.script')
@stop
