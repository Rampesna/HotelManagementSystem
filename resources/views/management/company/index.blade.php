@extends('layouts.master')
@section('title', 'Firmalar')
@php(setlocale(LC_ALL, 'tr_TR.UTF-8'))
@php(setlocale(LC_TIME, 'Turkish'))

@section('content')

    @include('management.company.components.create_company_rightbar')
    @include('management.company.components.edit_company_rightbar')

    @include('management.company.modals.delete')

    <div class="row">
        <div class="col-xl-12">
            <div class="card" id="companiesCard">
                <div class="card-body">
                    <table class="table" id="companies">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Firma Ünvanı</th>
                            <th>Firma Vergi Numarası</th>
                            <th>Tanımlı İndirim Yüzdesi</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Firma Ünvanı</th>
                            <th>Firma Vergi Numarası</th>
                            <th>Tanımlı İndirim Yüzdesi</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" id="context-menu" style="width: 300px">
        <div id="createCompanyContext">
            <a onclick="createCompany()" class="dropdown-item cursor-pointer">
                <div class="row">
                    <div class="col-xl-12">
                        <i class="fas fa-plus-circle text-success"></i><span class="ml-4">Yeni Firma Ekle</span>
                    </div>
                </div>
            </a>
        </div>
        <div id="editCompanyContext">
            <hr>
            <a onclick="editCompany()" class="dropdown-item cursor-pointer">
                <div class="row">
                    <div class="col-xl-12">
                        <i class="fas fa-pen-alt text-primary"></i><span class="ml-4">Seçili Firmayı Düzenle</span>
                    </div>
                </div>
            </a>
        </div>
        <div id="deleteCompanyContext">
            <a onclick="deleteCompany()" class="dropdown-item cursor-pointer">
                <div class="row">
                    <div class="col-xl-12">
                        <i class="fas fa-trash-alt text-danger"></i><span class="ml-4">Seçili Firmayı Sil</span>
                    </div>
                </div>
            </a>
        </div>
    </div>

@endsection

@section('page-styles')
    @include('management.company.components.style')
@stop

@section('page-script')
    @include('management.company.components.script')
@stop
