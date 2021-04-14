@extends('layouts.master')
@section('title', 'Oda Yönetimi')
@php(setlocale(LC_ALL, 'tr_TR.UTF-8'))
@php(setlocale(LC_TIME, 'Turkish'))

@section('content')

    @include('management.room.components.create_reservation_rightbar')
    @include('management.room.components.edit_reservation_rightbar')
    @include('management.room.components.reservation_safe_activities_rightbar')

    @include('management.room.modals.edit-reservation-create-customer')
    @include('management.room.modals.edit-reservation-select-customer')
    @include('management.room.modals.create-customer')
    @include('management.room.modals.select-customer')
    @include('management.room.modals.add-extra-reservation')
    @include('management.room.modals.get-payment')
    @include('management.room.modals.set-room-price-collective')
    @include('management.room.modals.set-room-status-collective')

    <input type="hidden" id="edit_reservation_rightbar_toggle">
    <input type="hidden" id="reservation_safe_activities_rightbar_toggle">
    <input type="hidden" id="create_reservation_rightbar_toggle">

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
                                    @if(!$room->activeReservation())
                                        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                            <ul class="navi navi-hover">
                                                @foreach($roomStatuses as $roomStatus)
                                                    <li class="navi-item" @if($roomStatus->id == 2) style="display: none" @endif>
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
                                    @endif
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
                        <h1 id="room_number_selector_{{ $room->id }}" class="cursor-pointer text-{{ $room->status->color }}" onclick="showReservation({{ $room->activeReservation()->id ?? null }})" style="font-size: 32px">{{ $room->number }}</h1>
                        @if($room->activeReservation())
                            <span id="reservationCheckout_{{ $room->activeReservation()->id }}" onclick="getReservationExtras({{ $room->activeReservation()->id }})" class="font-weight-bold cursor-pointer">{{ number_format($room->activeReservation()->debtControl(), 2) . ' TL' }}</span>
                        @else
                            <span>{{ $room->type->name }}</span>
                        @endif
                    </div>
                    <div class="card-footer py-3 text-center">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="dropdown dropdown-inline">
                                    <a class="roomPlusIcon" data-id="{{ $room->id }}" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-plus-circle fa-lg text-dark-75"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-sm" id="roomDropdownList_{{ $room->id }}" style="width: 300px">
                                        <ul class="navi navi-hover">
                                            @if(!$room->activeReservation())
                                                <li class="navi-item" id="createReservationDropdownRoomId_{{ $room->id }}">
                                                    <a data-room-id="{{ $room->id }}" class="navi-link cursor-pointer reservationCreator">
                                                        <span class="navi-icon">
                                                            <i class="fas fa-plus-circle"></i>
                                                        </span>
                                                        <span class="navi-text">Rezervasyon Oluştur</span>
                                                    </a>
                                                </li>
                                            @else
                                                <li class="navi-item">
                                                    <a onclick="getPaymentModal({{ $room->activeReservation()->id ?? null }})" class="navi-link cursor-pointer">
                                                        <span class="navi-icon">
                                                            <i class="fas fa-money-check text-primary"></i>
                                                        </span>
                                                        <span class="navi-text">Checkout</span>
                                                    </a>
                                                </li>
                                                <li class="navi-item">
                                                    <a onclick="openAddExtraModal({{ $room->activeReservation()->id ?? null }})" class="navi-link cursor-pointer">
                                                        <span class="navi-icon">
                                                            <i class="fas fa-plus-circle text-success"></i>
                                                        </span>
                                                        <span class="navi-text">Ekstra Ekle</span>
                                                    </a>
                                                </li>
                                                <div id="endReservationDropdown_{{ $room->activeReservation()->id }}" @if($room->activeReservation()->debtControl() <= 0) style="display: none" @endif>
                                                    <hr>
                                                    <li class="navi-item" >
                                                        <a onclick="endReservation({{ $room->activeReservation()->id }})" class="navi-link cursor-pointer">
                                                            <span class="navi-icon">
                                                                <i class="fas fa-stop-circle text-dark-75"></i>
                                                            </span>
                                                            <span class="navi-text">Konaklamayı Sonlandır</span>
                                                        </a>
                                                    </li>
                                                </div>
                                            @endif

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

    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" id="context-menu" style="width: 250px">

        <a data-toggle="modal" data-target="#SetRoomPriceCollectiveModal" class="dropdown-item cursor-pointer">
            <div class="row">
                <div class="col-xl-12">
                    <i class="fas fa-coins"></i><span class="ml-5">Oda Fiyatlarını Değiştir</span>
                </div>
            </div>
        </a>

        <a data-toggle="modal" data-target="#SetRoomStatusCollectiveModal" class="dropdown-item cursor-pointer">
            <div class="row">
                <div class="col-xl-12">
                    <i class="fas fa-undo-alt"></i><span class="ml-5">Oda Durumlarını Değiştir</span>
                </div>
            </div>
        </a>

    </div>

@endsection

@section('page-styles')
    @include('management.room.components.style')
@stop

@section('page-script')
    @include('management.room.components.script')
@stop
