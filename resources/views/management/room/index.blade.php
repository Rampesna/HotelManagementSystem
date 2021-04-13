@extends('layouts.master')
@section('title', 'Oda Yönetimi')
@php(setlocale(LC_ALL, 'tr_TR.UTF-8'))
@php(setlocale(LC_TIME, 'Turkish'))

@section('content')

    @include('management.room.modals.add-extra-reservation')

    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" id="context-menu" style="width: 250px">
        <a class="dropdown-item cursor-pointer">
            <div class="row">
                <div class="col-xl-12">
                    <span>İşlem 1</span>
                </div>
            </div>
        </a>
        <a class="dropdown-item cursor-pointer">
            <div class="row">
                <div class="col-xl-12">
                    <span>İşlem 2</span>
                </div>
            </div>
        </a>
        <a class="dropdown-item cursor-pointer">
            <div class="row">
                <div class="col-xl-12">
                    <span>İşlem 3</span>
                </div>
            </div>
        </a>
        <a class="dropdown-item cursor-pointer">
            <div class="row">
                <div class="col-xl-12">
                    <span>İşlem 4</span>
                </div>
            </div>
        </a>
    </div>

    <div class="row">
        @foreach($rooms as $room)
            <div class="col-xl-2 mt-10">
                <div class="card">
                    <div class="card-header py-4">
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="dropdown dropdown-inline ml-n3">
                                    <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span id="room_span_id_{{ $room->id }}" class="btn btn-pill btn-sm btn-{{ $room->status->color }}" style="font-size: 11px; height: 20px; padding-top: 2px">{{ $room->status->name }}</span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                        <ul class="navi navi-hover">
                                            @foreach($roomStatuses as $roomStatus)
                                            <li class="navi-item">
                                                <a data-id="{{ $room->id }}" data-status-id="{{ $roomStatus->id }}" class="navi-link cursor-pointer roomStatusSelector" id="room_status_selector_id_{{ $room->id }}">
                                                    <span class="navi-icon">
                                                        <i data-test="{{ $room->id . '_' . $roomStatus->id }}" class="dropdown_icon_selector fa fa-check-circle @if($room->status->id == $roomStatus->id) text-success @endif"></i>
                                                    </span>
                                                    <span class="navi-text">{{ $roomStatus->name }}</span>
                                                </a>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 text-right">
                                <label class="checkbox checkbox-success checkbox-lg mr-n6">
                                    <input type="checkbox" class="roomChecker" data-id="{{ $room->id }}" id="room_checked_id_{{ $room->id }}" />
                                    <span class="mt-n5"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="card-body text-center py-5">
                        <h1 style="font-size: 32px">{{ $room->number }}</h1>
                        {{ $room->type->name }}
                    </div>
                    <div class="card-footer py-3">
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="dropdown dropdown-inline ml-n5">
                                    <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-plus-circle text-dark-75"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-sm" style="width: 350px">
                                        <ul class="navi navi-hover">

                                            <li class="navi-item">
                                                <a class="navi-link cursor-pointer roomTransactionSelector" id="room_transaction_selector_id_{{ $room->id }}">
                                            <span class="navi-icon">
                                                <i class="fas fa-plus-circle"></i>
                                            </span>
                                                    <span class="navi-text">Rezervasyon Oluştur</span>
                                                </a>
                                            </li>

                                            <li class="navi-item">
                                                <a onclick="openAddExtraModal()"  class="navi-link cursor-pointer roomTransactionSelector" id="room_transaction_selector_id_{{ $room->id }}">
                                            <span class="navi-icon">
                                                <i class="fas fa-plus-circle"></i>
                                            </span>
                                                    <span class="navi-text">Ekstra Ekle</span>
                                                </a>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 text-right">
                                <div class="dropdown dropdown-inline ml-n3 mr-n5">
                                    <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-sort-amount-down-alt text-dark-75"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-sm" style="width: 350px">
                                        <ul class="navi navi-hover">



                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

@endsection

@section('page-styles')
    @include('management.room.components.style')
@stop

@section('page-script')
    @include('management.room.components.script')
@stop
