@extends('layouts.master')
@section('title', 'Devir İşlemleri Geçmişi')
@php(setlocale(LC_ALL, 'tr_TR.UTF-8'))


@section('content')

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <table class="table" id="handOvers">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Tarih</th>
                            <th>Devir Eden</th>
                            <th>Devir Alan</th>
                            <th>Devredilen Gelir</th>
                            <th>Devredilen Gider</th>
                            <th>Devredilen Kasa Tutarı</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Tarih</th>
                            <th>Devir Eden</th>
                            <th>Devir Alan</th>
                            <th>Devredilen Gelir</th>
                            <th>Devredilen Gider</th>
                            <th>Devredilen Kasa Tutarı</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('page-styles')
    @include('management.hand-over.components.style')
@stop

@section('page-script')
    @include('management.hand-over.components.script')
@stop
