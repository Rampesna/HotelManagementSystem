<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Receipt;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\SafeActivity;
use App\Services\ReceiptService;
use App\Services\SafeActivityService;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ReceiptsController extends Controller
{
    public function index(Request $request)
    {
        setlocale(LC_ALL, 'tr_TR.UTF-8');
        setlocale(LC_TIME, 'Turkish');

        return Datatables::of(Receipt::query())->
        filterColumn('user_id', function ($receipts, $id) {
            return $id == 0 ? $receipts : $receipts->where('user_id', $id);
        })->
        filterColumn('direction', function ($receipts, $id) {
            return $id == 2 ? $receipts : $receipts->where('direction', $id);
        })->
        editColumn('user_id', function ($receipt) {
            return $receipt->user->name;
        })->
        editColumn('date', function ($receipt) {
            return date('d.m.Y, H:i', strtotime($receipt->date));
        })->
        editColumn('price', function ($receipt) {
            return number_format($receipt->price, 2) . ' TL';
        })->
        editColumn('direction', function ($receipt) {
            return '<span class="btn btn-pill btn-sm btn-' . ($receipt->direction == 1 ? 'success' : 'danger') . '" style="font-size: 11px; height: 20px; padding-top: 2px">' . ($receipt->direction == 1 ? 'Gelir' : 'Gider') . '</span>';
        })->
        rawColumns(['direction'])->
        make(true);
    }

    public function save(Request $request)
    {
        $receiptService = new ReceiptService;
        $receiptService->setReceipt($request->id ? Receipt::find($request->id) : new Receipt);
        return response()->json($receiptService->save($request), 200);
    }

    public function safeTotal(Request $request)
    {
        $receipts = Receipt::all();
        return response()->json(number_format($receipts->where('direction', 1)->sum('price') - $receipts->where('direction', 0)->sum('price'), 2) . ' TL', 200);
    }

    public function receiptsByDate(Request $request)
    {
        $receipts = Receipt::whereBetween('date', [
            date('Y-m-d 00:00:00', strtotime($request->start_date)),
            date('Y-m-d 23:59:59', strtotime($request->end_date))
        ])->get();
        return response()->json([
            'incoming' => $receipts->where('direction', 1)->sum('price'),
            'outgoing' => $receipts->where('direction', 0)->sum('price')
        ], 200);
    }
}
