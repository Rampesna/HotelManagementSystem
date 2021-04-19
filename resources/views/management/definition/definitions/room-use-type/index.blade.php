@extends('layouts.master')
@section('title', 'Oda Kullanım Türleri')
@php(setlocale(LC_ALL, 'tr_TR.UTF-8'))
@php(setlocale(LC_TIME, 'Turkish'))

@section('content')

    @include('management.definition.definitions.room-use-type.components.create_room_use_type_rightbar')
    @include('management.definition.definitions.room-use-type.components.edit_room_use_type_rightbar')

    @include('management.definition.definitions.room-use-type.modals.delete')

    <div class="row">
        <div class="col-xl-12">
            <div class="card" id="roomUseTypesCard">
                <div class="card-body">
                    <table class="table" id="roomUseTypes">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Adı</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Adı</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" id="context-menu" style="width: 300px">
        <div id="createRoomUseTypeContext">
            <a onclick="createRoomUseType()" class="dropdown-item cursor-pointer">
                <div class="row">
                    <div class="col-xl-12">
                        <i class="fas fa-plus-circle text-success"></i><span class="ml-4">Yeni Oda Kullanım Türü Ekle</span>
                    </div>
                </div>
            </a>
        </div>
        <div id="editRoomUseTypeContext">
            <hr>
            <a onclick="editRoomUseType()" class="dropdown-item cursor-pointer">
                <div class="row">
                    <div class="col-xl-12">
                        <i class="fas fa-pen-alt text-primary"></i><span class="ml-4">Seçili Oda Kullanım Türünü Düzenle</span>
                    </div>
                </div>
            </a>
        </div>
        <div id="deleteRoomUseTypeContext">
            <a onclick="deleteRoomUseType()" class="dropdown-item cursor-pointer">
                <div class="row">
                    <div class="col-xl-12">
                        <i class="fas fa-trash-alt text-danger"></i><span class="ml-4">Seçili Oda Kullanım Türünü Sil</span>
                    </div>
                </div>
            </a>
        </div>
    </div>

@endsection

@section('page-styles')
    @include('management.definition.definitions.room-use-type.components.style')
@stop

@section('page-script')
    @include('management.definition.definitions.room-use-type.components.script')
@stop
