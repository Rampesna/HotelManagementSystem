@extends('layouts.master')
@section('title', 'Anasayfa')
@php(setlocale(LC_ALL, 'tr_TR.UTF-8'))

@section('content')



@endsection

@section('page-styles')
    @include('management.dashboard.components.style')
@stop

@section('page-script')
    @include('management.dashboard.components.script')
@stop
