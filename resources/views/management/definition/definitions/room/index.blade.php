@extends('layouts.master')
@section('title', 'Odalar')
@php(setlocale(LC_ALL, 'tr_TR.UTF-8'))
@php(setlocale(LC_TIME, 'Turkish'))

@section('content')

    @include('management.definition.definitions.room.components.create_room_rightbar')
    @include('management.definition.definitions.room.components.edit_room_rightbar')

    @include('management.definition.definitions.room.modals.delete')

    <div class="row">
        <div class="col-xl-12">
            <div class="card" id="roomsCard">
                <div class="card-body">
                    <table class="table" id="rooms">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Oda Numarası</th>
                            <th>Oda Ücreti</th>
                            <th>Oda Türü</th>
                            <th>Pan Türü</th>
                            <th>Kişi Sayısı</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Oda Numarası</th>
                            <th>Oda Ücreti</th>
                            <th>Oda Türü</th>
                            <th>Pan Türü</th>
                            <th>Kişi Sayısı</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" id="context-menu" style="width: 300px">
        <div id="createRoomContext">
            <a onclick="createRoom()" class="dropdown-item cursor-pointer">
                <div class="row">
                    <div class="col-xl-12">
                        <i class="fas fa-plus-circle text-success"></i><span class="ml-4">Yeni Oda Ekle</span>
                    </div>
                </div>
            </a>
        </div>
        <div id="editRoomContext">
            <hr>
            <a onclick="editRoom()" class="dropdown-item cursor-pointer">
                <div class="row">
                    <div class="col-xl-12">
                        <i class="fas fa-pen-alt text-primary"></i><span class="ml-4">Seçili Odayı Düzenle</span>
                    </div>
                </div>
            </a>
        </div>
        <div id="deleteRoomContext">
            <a onclick="deleteRoom()" class="dropdown-item cursor-pointer">
                <div class="row">
                    <div class="col-xl-12">
                        <i class="fas fa-trash-alt text-danger"></i><span class="ml-4">Seçili Odayı Sil</span>
                    </div>
                </div>
            </a>
        </div>
    </div>

@endsection

@section('page-styles')
    @include('management.definition.definitions.room.components.style')
@stop

@section('page-script')
    @include('management.definition.definitions.room.components.script')
@stop
