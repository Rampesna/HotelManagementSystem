@extends('layouts.master')
@section('title', 'Kasa')
@php(setlocale(LC_ALL, 'tr_TR.UTF-8'))
@php(setlocale(LC_TIME, 'Turkish'))

@section('content')

    @include('management.safe.modals.create-receipt')
    @include('management.safe.modals.hand-over')
    @include('management.safe.modals.day-end')

    <div class="row">
        <div class="col-xl-3 mb-3">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-xl-9">
                            <h4>Kasa</h4>
                        </div>
                        <div class="col-xl-3 text-right">
                            <div class="dropdown dropdown-inline ml-n3">
                                <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-plus-circle fa-lg text-success cursor-pointer"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                    <ul class="navi navi-hover">
                                        <li class="navi-item">
                                            <a data-toggle="modal" data-target="#CreateReceiptModal" class="navi-link cursor-pointer">
                                                <span class="navi-icon">
                                                    <i class="fa fa-check-circle"></i>
                                                </span>
                                                <span class="navi-text">Yeni Fiş Oluştur</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body text-center py-10">
                    @Authority(20)
                    <a href="{{ route('management.receipt.index') }}">
                        <h1 id="safeTotalSpan" class="cursor-pointer" style="font-size: 32px">--</h1>
                    </a>
                    @else
                    <a>
                        <h1 id="safeTotalSpan" style="font-size: 32px">--</h1>
                    </a>
                    @endAuthority
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col">
                            <button class="btn btn-sm btn-info" id="TriggerHandOverButton">Kasayı Devret</button>
                        </div>
                        <div class="col text-right">
                            <button class="btn btn-sm btn-dark-75" id="TriggerDayEndButton">Gün Sonu Yap</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-9">
            <div class="row">
                <div class="col-xl-4 mb-3">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-xl-12">
                                    <h4>Gün Sonu</h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="dailyCard"></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 mb-3">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-xl-12">
                                    <h4>Haftalık Durum</h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="weeklyCard"></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 mb-3">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-xl-12">
                                    <h4>Aylık Durum</h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="monthlyCard"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('page-styles')
    @include('management.safe.components.style')
@stop

@section('page-script')
    @include('management.safe.components.script')
@stop
