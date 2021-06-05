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

    @Authority(3)
    <div class="row">
        <div class="col-xl-12">
            <button id="create_reservation_rightbar_toggle" class="btn btn-primary">Yeni Rezervasyon Oluştur</button>
        </div>
    </div>
    <hr>
    @endAuthority
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    Detaylı Arama
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-3">
                            <div class="form-group">
                                <label for="f_start_date">Başlangıç Tarihi</label>
                                <input type="datetime-local" id="f_start_date" value="{{ date('Y-m-d') . 'T00:00' }}" name="start_date" class="form-control receiptsFilterer">
                            </div>
                        </div>
                        <div class="col-xl-3">
                            <div class="form-group">
                                <label for="f_end_date">Bitiş Tarihi</label>
                                <input type="datetime-local" id="f_end_date" name="end_date" class="form-control receiptsFilterer">
                            </div>
                        </div>
                        <div class="col-xl-3">
                            <div class="form-group">
                                <label for="f_min_price">Min. Oda Ücreti</label>
                                <input type="text" id="f_min_price" name="min_price" class="form-control decimal receiptsFilterer">
                            </div>
                        </div>
                        <div class="col-xl-3">
                            <div class="form-group">
                                <label for="f_max_price">Max. Oda Ücreti</label>
                                <input type="text" id="f_max_price" name="max_price" class="form-control decimal receiptsFilterer">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12 text-right">
                            <button class="btn btn-sm btn-primary" id="clearFilterReceiptsButton">Temizle</button>
                            <button class="btn btn-sm btn-success" id="filterReceiptsButton">Filtrele</button>
                        </div>
                    </div>
                </div>
            </div>
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
                            <th>Firma</th>
                            <th>Geliş Tarihi</th>
                            <th>Gidiş Tarihi</th>
                            <th>Durum</th>
                            <th>Oda Türü</th>
                            <th>Pan Türü</th>
                            <th>Oda Numarası</th>
                            <th>Oda Ücreti</th>
                            <th>Borç</th>
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
                            <th>Oda Ücreti</th>
                            <th>Borç</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" id="context-menu" style="width: 300px">
        <div id="reservationEditContext">
            @Authority(4)
            <a class="dropdown-item cursor-pointer">
                <div class="row">
                    <div class="col-xl-12">
                        <i class="fas fa-pen-alt text-primary"></i><span class="ml-4">Düzenle</span>
                    </div>
                </div>
            </a>
        </div>
        @endAuthority
        <div id="reservationStartStayContext">
            @Authority(7)
            <hr>
            <a onclick="setStatus(4)" class="dropdown-item cursor-pointer">
                <div class="row">
                    <div class="col-xl-12">
                        <i class="fa fa-play-circle text-info"></i><span class="ml-4">Konaklamayı Başlat</span>
                    </div>
                </div>
            </a>
            @endAuthority
        </div>
        <div id="reservationStopStayContext">
            @Authority(8)
            <a onclick="setStatus(5)" class="dropdown-item cursor-pointer">
                <div class="row">
                    <div class="col-xl-12">
                        <i class="fa fa-stop-circle text-dark-75"></i><span class="ml-4">Konaklamayı Sonlandır</span>
                    </div>
                </div>
            </a>
            <hr>
            @endAuthority
        </div>
        <div id="reservationApproveContext">
            @Authority(5)
            <hr>
            <a onclick="setStatus(2)" class="dropdown-item cursor-pointer">
                <div class="row">
                    <div class="col-xl-12">
                        <i class="fas fa-check text-success"></i><span class="ml-4">Rezervasyonu Onayla</span>
                    </div>
                </div>
            </a>
            @endAuthority
        </div>
        <div id="reservationDenyContext">
            @Authority(6)
            <a onclick="setStatus(3)" class="dropdown-item cursor-pointer">
                <div class="row">
                    <div class="col-xl-12">
                        <i class="fas fa-times text-danger"></i><span class="ml-4">Rezervasyonu İptal Et</span>
                    </div>
                </div>
            </a>
            @endAuthority
        </div>
        <div id="downloadInvoiceContext">
            <a onclick="downloadInvoice()" class="dropdown-item cursor-pointer">
                <div class="row">
                    <div class="col-xl-12">
                        <i class="fas fa-file-download text-success"></i><span class="ml-4">Faturayı İndir</span>
                    </div>
                </div>
            </a>
        </div>
    </div>

@endsection

@section('page-styles')
    @include('management.reservation.components.style')
@stop

@section('page-script')
    @include('management.reservation.components.script')
@stop
