@extends('layouts.master')
@section('title', 'Anasayfa')
@php(setlocale(LC_ALL, 'tr_TR.UTF-8'))
@php(setlocale(LC_TIME, 'Turkish'))

@section('content')

    @include('management.dashboard.components.show_reservation_rightbar')

    <div class="row">
        <div class="col-xl-4 col-lg-12">
            <div class="row">
                <div class="col-xl-6 mb-5">
                    <div class="card">
                        <div class="card-header text-center">
                            <h5>Konaklayan Odalar</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-12 text-center my-n8">
                                    <span class="cursor-pointer" style="font-size: 72px">{{ count($stayers) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row text-center">
                                @foreach($roomUseTypes as $roomUseType)
                                    <div class="col-xl-4">
                                        <span class="cursor-pointer" data-container="body" data-toggle="tooltip" data-placement="top" title="{{ $roomUseType->name }}">{{ $roomUseType->short }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6 mb-5">
                    <div class="card">
                        <div class="card-header text-center">
                            <h5>Beklenen Gelişler</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-12 text-center my-n8">
                                    <span class="cursor-pointer" style="font-size: 72px">{{ count($waitingIncoming) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row text-center">
                                @foreach($roomUseTypes as $roomUseType)
                                    <div class="col-xl-4">
                                        <span class="cursor-pointer" data-container="body" data-toggle="tooltip" data-placement="top" title="{{ $roomUseType->name }}">{{ $roomUseType->short }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-6 mb-5">
                    <div class="card">
                        <div class="card-header text-center">
                            <h5>Beklenen Çıkışlar</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-12 text-center my-n8">
                                    <span class="cursor-pointer" style="font-size: 72px">{{ count($waitingOutgoing) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row text-center">
                                @foreach($roomUseTypes as $roomUseType)
                                    <div class="col-xl-4">
                                        <span class="cursor-pointer" data-container="body" data-toggle="tooltip" data-placement="top" title="{{ $roomUseType->name }}">{{ $roomUseType->short }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6 mb-5">
                    <div class="card">
                        <div class="card-header text-center">
                            <h5>Gün Sonu</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-12 text-center my-n8">
                                    <span class="cursor-pointer" style="font-size: 72px">{{ count($stayers) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row text-center">
                                @foreach($roomUseTypes as $roomUseType)
                                    <div class="col-xl-4">
                                        <span class="cursor-pointer" data-container="body" data-toggle="tooltip" data-placement="top" title="{{ $roomUseType->name }}">{{ $roomUseType->short }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8 col-lg-12">
            <div class="row">
                <div class="col-xl-12 mb-5">
                    <div class="card">
                        <div class="card-body">
                            <div id="reservationsCalendar"></div>
                        </div>
                    </div>
                </div>
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
