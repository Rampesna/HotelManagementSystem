@extends('layouts.master')
@section('title', 'Ayarlar')
@php(setlocale(LC_ALL, 'tr_TR.UTF-8'))


@section('content')

    <div class="row">
        <div class="col-xl-4">
            <div class="row">
                <div class="col-xl-12">
                    <button class="btn btn-block btn-primary" id="setNight">Night İşlemi Gerçekleştir</button>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('page-styles')
    @include('management.setting.components.style')
@stop

@section('page-script')
    @include('management.setting.components.script')
@stop
