@extends('layouts.master')
@section('title', 'Extralar')
@php(setlocale(LC_ALL, 'tr_TR.UTF-8'))
@php(setlocale(LC_TIME, 'Turkish'))

@section('content')

    @include('management.definition.definitions.extra.components.create_extra_rightbar')
    @include('management.definition.definitions.extra.components.edit_extra_rightbar')

    @include('management.definition.definitions.extra.modals.delete')

    <div class="row">
        <div class="col-xl-12">
            <div class="card" id="extrasCard">
                <div class="card-body">
                    <table class="table" id="extras">
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
        <div id="createExtraContext">
            <a onclick="createExtra()" class="dropdown-item cursor-pointer">
                <div class="row">
                    <div class="col-xl-12">
                        <i class="fas fa-plus-circle text-success"></i><span class="ml-4">Yeni Extra Ekle</span>
                    </div>
                </div>
            </a>
        </div>
        <div id="editExtraContext">
            <hr>
            <a onclick="editExtra()" class="dropdown-item cursor-pointer">
                <div class="row">
                    <div class="col-xl-12">
                        <i class="fas fa-pen-alt text-primary"></i><span class="ml-4">Seçili Extrayı Düzenle</span>
                    </div>
                </div>
            </a>
        </div>
        <div id="deleteExtraContext">
            <a onclick="deleteExtra()" class="dropdown-item cursor-pointer">
                <div class="row">
                    <div class="col-xl-12">
                        <i class="fas fa-trash-alt text-danger"></i><span class="ml-4">Seçili Extrayı Sil</span>
                    </div>
                </div>
            </a>
        </div>
    </div>

@endsection

@section('page-styles')
    @include('management.definition.definitions.extra.components.style')
@stop

@section('page-script')
    @include('management.definition.definitions.extra.components.script')
@stop
