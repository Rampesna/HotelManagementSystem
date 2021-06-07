@extends('layouts.master')
@section('title', 'Gün Sonu Geçmişi')
@php(setlocale(LC_ALL, 'tr_TR.UTF-8'))


@section('content')

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <table class="table" id="dayEnds">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Tarih</th>
                            <th>İşlemi Yapan</th>
                            <th>Çekilen Tutar</th>
                            <th>Kalan Tutar</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Tarih</th>
                            <th>İşlemi Yapan</th>
                            <th>Çekilen Tutar</th>
                            <th>Kalan Tutar</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('page-styles')
    @include('management.day-end.components.style')
@stop

@section('page-script')
    @include('management.day-end.components.script')
@stop
