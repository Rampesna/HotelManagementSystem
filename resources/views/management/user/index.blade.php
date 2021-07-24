@extends('layouts.master')
@section('title', 'Kullanıcılar')
@php(setlocale(LC_ALL, 'tr_TR.UTF-8'))

@section('content')

    @include('management.user.modals.create')
    @include('management.user.modals.edit')
    @include('management.user.modals.delete')

    <div class="row">
        <div class="col-xl-12 text-right">
            <button type="button" data-toggle="modal" data-target="#CreateModal" class="btn btn-primary">Yeni Kullanıcı Oluştur</button>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-xl-12">
            <div class="card" id="usersCard">
                <div class="card-body">
                    <table class="table" id="users">
                        <thead>
                        <tr>
                            <th>Ad Soyad</th>
                            <th>Rol</th>
                            <th>Durum</th>
                            <th>E-posta</th>
                            <th>Telefon Numarası</th>
                            <th>Kimlik Numarası</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Ad Soyad</th>
                            <th>Rol</th>
                            <th>Durum</th>
                            <th>E-posta</th>
                            <th>Telefon Numarası</th>
                            <th>Kimlik Numarası</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" id="context-menu" style="width: 300px">
        <a onclick="create()" class="dropdown-item cursor-pointer">
            <div class="row">
                <div class="col-xl-12">
                    <i class="fas fa-plus-circle text-success"></i><span class="ml-4">Yeni Oluştur</span>
                </div>
            </div>
        </a>
        <div id="editContexts">
            <hr>
            <a onclick="edit()" class="dropdown-item cursor-pointer">
                <div class="row">
                    <div class="col-xl-12">
                        <i class="fas fa-pen-alt text-primary"></i><span class="ml-4">Düzenle</span>
                    </div>
                </div>
            </a>
            <a onclick="drop()" class="dropdown-item cursor-pointer">
                <div class="row">
                    <div class="col-xl-12">
                        <i class="fas fa-trash-alt text-danger"></i><span class="ml-4">Sil</span>
                    </div>
                </div>
            </a>
        </div>
    </div>

@endsection

@section('page-styles')
    @include('management.user.components.style')
@stop

@section('page-script')
    @include('management.user.components.script')
@stop
