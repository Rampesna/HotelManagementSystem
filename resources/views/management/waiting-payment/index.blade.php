@extends('layouts.master')
@section('title', 'Beklenen Ödemeler')
@php(setlocale(LC_ALL, 'tr_TR.UTF-8'))
@php(setlocale(LC_TIME, 'Turkish'))

@section('content')

    @include('management.waiting-payment.modals.get-payment')

    <div class="row">
        <div class="col-xl-12">
            <div class="card" id="waitingPaymentsCard">
                <div class="card-body">
                    <table class="table" id="waitingPayments">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Rezervasyon Adı</th>
                            <th>Durum</th>
                            <th>Ödenecek Tutar</th>
                            <th>Ödenme Tarihi</th>
                            <th>Ödemeyi Alan</th>
                            <th>Rezervasyon Başlangıç Tarihi</th>
                            <th>Rezervasyon Bitiş Tarihi</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Rezervasyon Adı</th>
                            <th>Durum</th>
                            <th>Ödenecek Tutar</th>
                            <th>Ödenme Tarihi</th>
                            <th>Ödemeyi Alan</th>
                            <th>Rezervasyon Başlangıç Tarihi</th>
                            <th>Rezervasyon Bitiş Tarihi</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" id="context-menu" style="width: 300px">
        <div id="getPaymentContext">
            @Authority(24)
            <a onclick="getPayment()" class="dropdown-item cursor-pointer">
                <div class="row">
                    <div class="col-xl-12">
                        <i class="fas fa-plus-circle text-success"></i><span class="ml-4">Ödeme Al</span>
                    </div>
                </div>
            </a>
            @endAuthority
        </div>
    </div>

@endsection

@section('page-styles')
    @include('management.waiting-payment.components.style')
@stop

@section('page-script')
    @include('management.waiting-payment.components.script')
@stop
