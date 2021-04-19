@extends('layouts.master')
@section('title', 'Müşteriler')
@php(setlocale(LC_ALL, 'tr_TR.UTF-8'))
@php(setlocale(LC_TIME, 'Turkish'))

@section('content')

    @include('management.customer.components.create_customer_rightbar')
    @include('management.customer.components.edit_customer_rightbar')

    <div class="row">
        <div class="col-xl-12">
            <div class="card" id="customersCard">
                <div class="card-body">
                    <table class="table" id="customers">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Ad</th>
                            <th>Soyad</th>
                            <th>Ünvan</th>
                            <th>Kimlik Numarası</th>
                            <th>Cinsiyet</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Ad</th>
                            <th>Soyad</th>
                            <th>Ünvan</th>
                            <th>Kimlik Numarası</th>
                            <th>Cinsiyet</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" id="context-menu" style="width: 300px">
        <div id="createCustomerContext">
            <a onclick="createCustomer()" class="dropdown-item cursor-pointer">
                <div class="row">
                    <div class="col-xl-12">
                        <i class="fas fa-plus-circle text-success"></i><span class="ml-4">Yeni Müşteri Ekle</span>
                    </div>
                </div>
            </a>
        </div>
        <div id="editCustomerContext">
            <hr>
            <a onclick="editCustomer()" class="dropdown-item cursor-pointer">
                <div class="row">
                    <div class="col-xl-12">
                        <i class="fas fa-pen-alt text-primary"></i><span class="ml-4">Seçili Müşteriyi Düzenle</span>
                    </div>
                </div>
            </a>
        </div>
    </div>

@endsection

@section('page-styles')
    @include('management.customer.components.style')
@stop

@section('page-script')
    @include('management.customer.components.script')
@stop
