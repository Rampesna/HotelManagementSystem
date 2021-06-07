<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\HandOver;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class HandOversController extends Controller
{
    public function datatable(Request $request)
    {
        return Datatables::of(HandOver::query())->
        filterColumn('from', function ($handOvers, $keyword) {
            return $handOvers->whereIn('from', User::where('name', 'like', '%' . $keyword . '%')->pluck('id')->toArray());
        })->
        filterColumn('to', function ($handOvers, $keyword) {
            return $handOvers->whereIn('to', User::where('name', 'like', '%' . $keyword . '%')->pluck('id')->toArray());
        })->
        editColumn('id', function ($handOver) {
            return '#' . $handOver->id;
        })->
        editColumn('from', function ($handOver) {
            return $handOver->fromUser->name;
        })->
        editColumn('to', function ($handOver) {
            return $handOver->toUser->name;
        })->
        editColumn('incoming', function ($handOver) {
            return $handOver->incoming . ' TL';
        })->
        editColumn('outgoing', function ($handOver) {
            return $handOver->outgoing . ' TL';
        })->
        editColumn('total', function ($handOver) {
            return $handOver->total . ' TL';
        })->
        editColumn('created_at', function ($handOver) {
            return date('d.m.Y, H:i', strtotime($handOver->created_at));
        })->
        make(true);
    }
}
