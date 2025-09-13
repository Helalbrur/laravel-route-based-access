<?php

namespace App\Http\Controllers;

use App\Models\LibSupplier;
use App\Models\WorkOrderMst;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $lib_supplier_arr = LibSupplier::all();
        $works_order = WorkOrderMst::with('Company','Supplier','workOrderDtls')->get();

        $totalWorkOrders = $works_order->count();
        $supplierTotals = [];
        $grandTotalQty = 0;
        $grandTotalAmount = 0;

        foreach ($works_order as $wo) {
            $wo->total_qty   = $wo->workOrderDtls->sum(fn($d) => (float) $d->quantity);
            $wo->total_value = $wo->workOrderDtls->sum(fn($d) => (float) $d->amount);

            $supplierId = $wo->Supplier->id ?? null;
            if ($supplierId) {
                if (!isset($supplierTotals[$supplierId])) {
                    $supplierTotals[$supplierId] = [
                        'supplier_id'   => $supplierId,
                        'supplier_name' => $wo->Supplier->supplier_name ?? '',
                        'total_qty'     => 0,
                        'total_amount'  => 0,
                    ];
                }
                $supplierTotals[$supplierId]['total_qty']    += $wo->total_qty;
                $supplierTotals[$supplierId]['total_amount'] += $wo->total_value;
            }

            $grandTotalQty    += $wo->total_qty;
            $grandTotalAmount += $wo->total_value;
        }


        // If you want supplier totals as a collection:
        $supplierTotals = collect($supplierTotals)->values();

        $allData = $this->getWorkOrderAnalytics();
        //dd($allData);

        //dd($supplierTotals, $grandTotalQty, $grandTotalAmount);

        //view()->share('supplier', $lib_supplier_arr);
        return view('dashboard',compact('lib_supplier_arr','works_order','supplierTotals','grandTotalQty','grandTotalAmount','totalWorkOrders','allData'));
    }


    public function getWorkOrderAnalytics()
    {
        $works_order = WorkOrderMst::with([
            'supplier',
            'workOrderDtls.product',
            'workOrderDtls.transactions'
        ])->get();

        $allData = [];

        foreach ($works_order as $wo) {
            foreach ($wo->workOrderDtls as $dtl) {
                $receiveQty = $dtl->transactions()
                                ->whereIn('transaction_type', [1,4,5]) // receive
                                ->sum('cons_qnty');

                $issueQty = $dtl->transactions()
                                ->whereIn('transaction_type', [2,3,6]) // issue/sales
                                ->sum('cons_qnty');

                $allData[] = [
                    'date'        => $wo->wo_date,
                    'supplier'    => $wo->supplier->supplier_name ?? 'Unknown',
                    'product'     => $dtl->product->product_name ?? 'N/A',
                    'sales'       => $issueQty * ($dtl->rate ?? 0),
                    'value'       => $dtl->amount ?? 0,
                    'workOrderQty'=> $dtl->quantity,
                    'receiveQty'  => $receiveQty,
                    'status'      => $this->getWorkOrderStatus($dtl, $receiveQty),
                ];
            }
        }

        return $allData; // ✅ return array, not response()->json()
    }


    /**
     * Determine work order detail status.
     */
    private function getWorkOrderStatus($dtl, $receiveQty)
    {
        if ($receiveQty >= $dtl->quantity) {
            return 'completed';
        } elseif ($receiveQty > 0) {
            return 'in-progress';
        }
        return 'pending';
    }

}
