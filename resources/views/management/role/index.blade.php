@extends('layouts.master')
@section('title', 'Roller')
@php(setlocale(LC_ALL, 'tr_TR.UTF-8'))

@section('content')

    <div class="row">
        <div class="col-xl-12 text-right">
            <button type="button" data-toggle="modal" data-target="#CreateModal" class="btn btn-primary">Yeni Rol Ekle</button>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-12">
                            <table class="table table-hover" id="roles">
                                <thead>
                                <tr>
                                    <th style="width: 3%"></th>
                                    <th>Rol Adı</th>
                                    <th class="text-right">İşlem Yetkileri</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($roles as $role)
                                    <tr id="row-{{ $role->id }}">
                                        @if($role->id == 1)
                                            <td style="width: 3%"></td>
                                        @else
                                            <td style="width: 3%" class="pt-4">
                                                <div class="dropdown dropdown-inline">
                                                    <a href="#" class="btn btn-clean btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="ki ki-bold-more-ver"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                                        <ul class="navi navi-hover">
                                                            <li class="navi-item">
                                                                <a href="#"
                                                                   data-id="{{ $role->id }}"
                                                                   data-toggle="modal"
                                                                   data-target="#EditModal"
                                                                   class="navi-link edit">
                                                                <span class="navi-icon">
                                                                    <i class="fa fa-edit"></i>
                                                                </span>
                                                                    <span class="navi-text">Düzenle</span>
                                                                </a>
                                                            </li>
                                                            <li class="navi-item">
                                                                <a href="#"
                                                                   data-id="{{ $role->id }}"
                                                                   data-toggle="modal"
                                                                   data-target="#DeleteModal"
                                                                   class="navi-link delete">
                                                                    <span class="navi-icon">
                                                                        <i class="fa fa-trash-alt text-danger"></i>
                                                                    </span>
                                                                    <span class="navi-text text-danger">Sil</span>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </td>
                                        @endif
                                        <td class="pt-6">{{ $role->name }}</td>
                                        <td class="text-right">
                                            <label for="{{ $role->id }}_permissions"></label>
                                            <select style="width: 100%" class="selectpicker" id="{{ $role->id }}_permissions" multiple>
                                                @foreach($permissions as $permission)
                                                    <option @if($role->permissions()->where('permission_id', $permission->id)->exists()) selected @endif value="{{ $permission->id }}">{{ $permission->name }}</option>
                                                @endforeach
                                            </select>
                                            @if($role->id != 1)
                                                <button type="button" data-role-id="{{ $role->id }}" class="btn btn-success btn-square permissionUpdate"><i class="far fa-save"></i> Kaydet</button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('management.role.modals.create')
    @include('management.role.modals.edit')
    @include('management.role.modals.delete')


@endsection

@section('page-styles')
    @include('management.role.components.style')
@stop

@section('page-script')
    @include('management.role.components.script')
@stop
