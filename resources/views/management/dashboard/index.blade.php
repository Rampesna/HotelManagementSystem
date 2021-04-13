@extends('layouts.master')
@section('title', 'Anasayfa')
@php(setlocale(LC_ALL, 'tr_TR.UTF-8'))
@php(setlocale(LC_TIME, 'Turkish'))

@section('content')

    <div class="row">

        <div class="col-xl-3">
            <div class="card">
                <div class="card-header text-center">
                    <h5>Konaklayan Odalar</h5>
                </div>
                <div class="card-body"></div>
                <div class="card-footer"></div>
            </div>
        </div>

        <div class="col-xl-3">
            <div class="card">
                <div class="card-header text-center">
                    <h5>Beklenen Gelişler</h5>
                </div>
                <div class="card-body"></div>
                <div class="card-footer"></div>
            </div>
        </div>

        <div class="col-xl-3">
            <div class="card">
                <div class="card-header text-center">
                    <h5>Beklenen Çıkışlar</h5>
                </div>
                <div class="card-body"></div>
                <div class="card-footer"></div>
            </div>
        </div>

        <div class="col-xl-3">
            <div class="card">
                <div class="card-header text-center">
                    <h5>Gün Sonu</h5>
                </div>
                <div class="card-body"></div>
                <div class="card-footer"></div>
            </div>
        </div>

    </div>


@endsection

@section('page-styles')
    @include('management.dashboard.components.style')
@stop

@section('page-script')
    @include('management.dashboard.components.script')
@stop
