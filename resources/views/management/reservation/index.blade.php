@extends('layouts.master')
@section('title', 'Rezervasyonlar')
@php(setlocale(LC_ALL, 'tr_TR.UTF-8'))

@section('content')

    @include('management.reservation.components.create_reservation_rightbar')

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
                            <th>Oda Türü</th>
                            <th>Pan Türü</th>
                            <th>Oda Numarası</th>
                            <th>Ücret</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($reservations as $reservation)
                            <tr>
                                <td>#{{ $reservation->id }}</td>
                                <td>{{ $reservation->customer->full_name }}</td>
                                <td data-sort="{{ date('Y-m-d H:i:s', strtotime($reservation->start_date)) }}">{{ strftime('%d %B %Y, %H:%M', strtotime($reservation->start_date)) }}</td>
                                <td data-sort="{{ date('Y-m-d H:i:s', strtotime($reservation->end_date)) }}">{{ strftime('%d %B %Y, %H:%M', strtotime($reservation->end_date)) }}</td>
                                <td>{{ $reservation->roomType->name }}</td>
                                <td>{{ $reservation->panType->name }}</td>
                                <td>{{ $reservation->room->number }}</td>
                                <td>{{ $reservation->price }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" id="context-menu" style="width: 250px">
        <a onclick="approve()" class="dropdown-item">
            <div class="row">
                <div class="col-xl-4">
                    <i class="fas fa-check text-success"></i>
                </div>
                <div class="col-xl-8">
                    <span>Seçilenleri Onayla</span>
                </div>
            </div>
        </a>
        <a onclick="deny()" class="dropdown-item">
            <div class="row">
                <div class="col-xl-4">
                    <i class="fas fa-times text-danger"></i>
                </div>
                <div class="col-xl-8">
                    <span>Seçilenleri İptal Et</span>
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
