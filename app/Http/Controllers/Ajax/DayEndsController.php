<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\DayEnd;
use App\Models\HandOver;
use App\Models\Receipt;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DayEndsController extends Controller
{
    public function datatable(Request $request)
    {
        return Datatables::of(DayEnd::query())->
        filterColumn('user_id', function ($dayEnds, $keyword) {
            return $dayEnds->whereIn('user_id', User::where('name', 'like', '%' . $keyword . '%')->pluck('id')->toArray());
        })->
        editColumn('id', function ($dayEnd) {
            return '#' . $dayEnd->id;
        })->
        editColumn('date', function ($dayEnd) {
            return date('d.m.Y, H:i', strtotime($dayEnd->date));
        })->
        editColumn('user_id', function ($dayEnd) {
            return $dayEnd->user()->withTrashed()->first() ? $dayEnd->user()->withTrashed()->first()->name : '';
        })->
        editColumn('withdrawn', function ($dayEnd) {
            return $dayEnd->withdrawn . ' TL';
        })->
        editColumn('remaining', function ($dayEnd) {
            return $dayEnd->remaining . ' TL';
        })->
        make(true);
    }

    public function receipts(Request $request)
    {
        return response()->json(Receipt::with([
            'paymentType'
        ])->whereIn('id', unserialize(DayEnd::find($request->id)->receipts))->get(), 200);
    }
}
