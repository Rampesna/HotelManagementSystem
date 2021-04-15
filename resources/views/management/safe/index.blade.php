@extends('layouts.master')
@section('title', 'Kasa')
@php(setlocale(LC_ALL, 'tr_TR.UTF-8'))
@php(setlocale(LC_TIME, 'Turkish'))

@section('content')

    @include('management.safe.modals.get-payment')

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
                            <th>Geliş Tarihi</th>
                            <th>Gidiş Tarihi</th>
                            <th>Durum</th>
                            <th>Oda Numarası</th>
                            <th>Ücret</th>
                            <th>Alınan Ödeme</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Müşteri</th>
                            <th>Geliş Tarihi</th>
                            <th>Gidiş Tarihi</th>
                            <th>Durum</th>
                            <th>Oda Numarası</th>
                            <th>Ücret</th>
                            <th>Alınan Ödeme</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" id="context-menu" style="width: 300px">
        <div id="downloadInvoice">
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
    @include('management.safe.components.style')
@stop

@section('page-script')
    @include('management.safe.components.script')
@stop
