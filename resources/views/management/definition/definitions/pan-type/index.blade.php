@extends('layouts.master')
@section('title', 'Oda Türleri')
@php(setlocale(LC_ALL, 'tr_TR.UTF-8'))
@php(setlocale(LC_TIME, 'Turkish'))

@section('content')

    @include('management.definition.definitions.pan-type.components.create_pan_type_rightbar')
    @include('management.definition.definitions.pan-type.components.edit_pan_type_rightbar')

    @include('management.definition.definitions.pan-type.modals.delete')

    <div class="row">
        <div class="col-xl-12">
            <div class="card" id="panTypesCard">
                <div class="card-body">
                    <table class="table" id="panTypes">
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
        <div id="createPanTypeContext">
            <a onclick="createPanType()" class="dropdown-item cursor-pointer">
                <div class="row">
                    <div class="col-xl-12">
                        <i class="fas fa-plus-circle text-success"></i><span class="ml-4">Yeni Pan Türü Ekle</span>
                    </div>
                </div>
            </a>
        </div>
        <div id="editPanTypeContext">
            <hr>
            <a onclick="editPanType()" class="dropdown-item cursor-pointer">
                <div class="row">
                    <div class="col-xl-12">
                        <i class="fas fa-pen-alt text-primary"></i><span class="ml-4">Seçili Pan Türünü Düzenle</span>
                    </div>
                </div>
            </a>
        </div>
        <div id="deletePanTypeContext">
            <a onclick="deletePanType()" class="dropdown-item cursor-pointer">
                <div class="row">
                    <div class="col-xl-12">
                        <i class="fas fa-trash-alt text-danger"></i><span class="ml-4">Seçili Pan Türünü Sil</span>
                    </div>
                </div>
            </a>
        </div>
    </div>

@endsection

@section('page-styles')
    @include('management.definition.definitions.pan-type.components.style')
@stop

@section('page-script')
    @include('management.definition.definitions.pan-type.components.script')
@stop
