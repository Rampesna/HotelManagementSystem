<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\DayEnd;
use App\Models\HandOver;
use App\Models\PaymentType;
use App\Models\Receipt;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\SafeActivity;
use App\Models\User;
use App\Services\DayEndService;
use App\Services\HandOverService;
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

        $receipts = Receipt::with([]);

        if ($request->start_date) {
            $receipts = $receipts->where('date', '>=', $request->start_date);
        }

        if ($request->end_date) {
            $receipts = $receipts->where('date', '<=', $request->end_date);
        }

        if ($request->min_price) {
            $receipts = $receipts->where('price', '>=', $request->min_price);
        }

        if ($request->max_price) {
            $receipts = $receipts->where('price', '<=', $request->max_price);
        }

        return Datatables::of($receipts)->
        filterColumn('user_id', function ($receipts, $id) {
            return $id == 0 ? $receipts : $receipts->where('user_id', $id);
        })->
        filterColumn('payment_type_id', function ($receipts, $keyword) {
            return $receipts->whereIn('payment_type_id', PaymentType::where('name', 'like', '%' . $keyword . '%')->get()->pluck('id'));
        })->
        filterColumn('direction', function ($receipts, $id) {
            return $id == 2 ? $receipts : $receipts->where('direction', $id);
        })->
        editColumn('user_id', function ($receipt) {
            return $receipt->user()->withTrashed()->first() ? $receipt->user()->withTrashed()->first()->name : '';
        })->
        editColumn('date', function ($receipt) {
            return date('d.m.Y, H:i', strtotime($receipt->date));
        })->
        editColumn('price', function ($receipt) {
            return number_format($receipt->price, 2) . ' TL';
        })->
        editColumn('payment_type_id', function ($receipt) {
            return $receipt->paymentType()->withTrashed()->first() ? $receipt->paymentType()->withTrashed()->first()->name : '';
        })->
        editColumn('direction', function ($receipt) {
            return '<span class="btn btn-pill btn-sm btn-' . ($receipt->direction == 1 ? 'danger' : 'success') . '" style="font-size: 11px; height: 20px; padding-top: 2px">' . ($receipt->direction == 1 ? 'Gider' : 'Gelir') . '</span>';
        })->
        rawColumns(['direction', 'description'])->
        make(true);
    }

    public function save(Request $request)
    {
        $receiptService = new ReceiptService;
        $receiptService->setReceipt($request->id ? Receipt::find($request->id) : new Receipt);
        return response()->json($receiptService->save(
            $request->user_id,
            $request->safe_id,
            $request->direction,
            $request->date,
            $request->price,
            $request->description,
            $request->payment_type_id
        ), 200);
    }

    public function safeTotal(Request $request)
    {
        $receipts = Receipt::where('day_end', 0)->get();
        return response()->json(number_format($receipts->where('direction', 0)->sum('price') - $receipts->where('direction', 1)->sum('price'), 2) . ' TL', 200);
    }

    public function receiptsByDate(Request $request)
    {
        $receipts = Receipt::where('day_end', 0)->whereBetween('date', [
            date('Y-m-d 00:00:00', strtotime($request->start_date)),
            date('Y-m-d 23:59:59', strtotime($request->end_date))
        ])->get();
        return response()->json([
            'incoming' => $receipts->where('direction', 0)->sum('price'),
            'outgoing' => $receipts->where('direction', 1)->sum('price')
        ], 200);
    }

    public function dayEndWaitingReceiptsForHandOver(Request $request)
    {
        $paymentTypes = PaymentType::all();
        $response = [];

        foreach ($paymentTypes as $paymentType) {
            $receipts = Receipt::where('user_id', auth()->user()->id())->where('day_end', 0)->where('payment_type_id', $paymentType->id)->get();
            $response[] = [
                'payment_type_id' => $paymentType->id,
                'payment_type_name' => $paymentType->name,
                'receipts' => $receipts,
                'receipts_total_incoming' => $receipts->where('direction', 0)->sum('price'),
                'receipts_total_outgoing' => $receipts->where('direction', 1)->sum('price')
            ];
        }

        $receipts = Receipt::where('user_id', auth()->user()->id())->where('day_end', 0)->where('payment_type_id', null)->get();
        $response[] = [
            'payment_type_id' => 0,
            'payment_type_name' => 'Ödeme Türü Belirsiz',
            'receipts' => $receipts,
            'receipts_total_incoming' => $receipts->where('direction', 0)->sum('price'),
            'receipts_total_outgoing' => $receipts->where('direction', 1)->sum('price')
        ];

        return response()->json($response, 200);
    }

    public function dayEndWaitingReceiptsForDayEnd(Request $request)
    {
        $paymentTypes = PaymentType::all();
        $response = [];
        $activeReservations = Reservation::where('status_id', 4)->pluck('id')->toArray();

        foreach ($paymentTypes as $paymentType) {
            $receipts = Receipt::where('created_at', '<=', $request->date)->where('day_end', 0)->whereNotIn('reservation_id', $activeReservations)->where('payment_type_id', $paymentType->id)->get();
            $response[] = [
                'payment_type_id' => $paymentType->id,
                'payment_type_name' => $paymentType->name,
                'receipts' => $receipts,
                'receipts_total_incoming' => $receipts->where('direction', 0)->sum('price'),
                'receipts_total_outgoing' => $receipts->where('direction', 1)->sum('price')
            ];
        }

        $receipts = Receipt::where('created_at', '<=', $request->date)->where('day_end', 0)->whereNotIn('reservation_id', $activeReservations)->where('payment_type_id', null)->get();
        $response[] = [
            'payment_type_id' => 0,
            'payment_type_name' => 'Ödeme Türü Belirsiz',
            'receipts' => $receipts,
            'receipts_total_incoming' => $receipts->where('direction', 0)->sum('price'),
            'receipts_total_outgoing' => $receipts->where('direction', 1)->sum('price')
        ];

        return response()->json($response, 200);
    }

    public function handOver(Request $request)
    {
        $receipts = Receipt::where('user_id', auth()->user()->id())->where('day_end', 0)->get();
        $incoming = 0;
        $outgoing = 0;
        foreach ($receipts as $receipt) {
            $receipt->user_id = $request->to;
            $receipt->save();

            $receipt->direction == 0 ? ($incoming += $receipt->price) : ($outgoing += $receipt->price);
        }

        $handOverService = new HandOverService;
        $handOverService->setHandOver(new HandOver);
        $handOverService->save($request->from, $request->to, serialize($receipts->pluck('id')->toArray()), $incoming, $outgoing, ($incoming - $outgoing));
    }

    public function dayEnd(Request $request)
    {
        $activeReservations = Reservation::where('status_id', 4)->pluck('id')->toArray();
        $receipts = Receipt::where('created_at', '<=', $request->date)->where('day_end', 0)->whereNotIn('reservation_id', $activeReservations)->get();

        foreach ($receipts as $receipt) {
            $receipt->day_end = 1;
            $receipt->save();
        }

        $dayEndService = new DayEndService;
        $dayEndService->setDayEnd(new DayEnd);
        $dayEndService->save($request->auth_user_id, $request->date, $request->withdrawn, $request->remaining, serialize($receipts->pluck('id')->toArray()));

        $receiptService = new ReceiptService;
        $receiptService->setReceipt(new Receipt);
        $receiptService->save(
            $request->auth_user_id,
            1,
            1,
            date('Y-m-d H:i:s'),
            $request->withdrawn,
            date('d.m.Y, H:i', strtotime($request->date)) . ' Tarihi İçin, "' . User::find($request->auth_user_id)->name . '" Tarafından Gün Sonu Yapılarak Kasadan Çekilen Tutar.',
            null,
            null,
            1
        );

        $receiptService = new ReceiptService;
        $receiptService->setReceipt(new Receipt);
        $receiptService->save(
            $request->auth_user_id,
            1,
            0,
            date('Y-m-d H:i:s'),
            $request->remaining,
            date('d.m.Y, H:i', strtotime($request->date)) . ' Tarihi İçin, "' . User::find($request->auth_user_id)->name . '" Tarafından Gün Sonu İşlemi Sonrası Kasada Kalan Tutar.'
        );
    }
}
