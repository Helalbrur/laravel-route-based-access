<?php

namespace App\Http\Controllers;

use App\Models\TransferMst;
use App\Models\InvTransaction;
use App\Models\ProductDetailsMaster;
use App\Models\RequisitionDtls;
use Doctrine\DBAL\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Throw_;

class TransferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('order_management.order.transfer');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cbo_company_name'      => 'required',
            'txt_transfer_date'     => 'required|date',
            'cbo_item_category'     => 'required',
            'hidden_product_id'     => 'required|integer',
            'txt_current_stock'     => 'required|numeric|min:1',
            'txt_avg_rate'          => 'required|numeric|min:1',
            'txt_transfer_qty'      => [
                'required',
                'numeric',
                'min:1',
                function ($attribute, $value, $fail) use ($request) {
                    if ($value > $request->txt_current_stock) {
                        $fail('The transfer quantity must not exceed the current stock.');
                    }
                }
            ],
            'cbo_location_from'     => 'required',
            'cbo_store_from'        => 'required',
            'cbo_floor_name_from'   => 'required',
            'cbo_room_no_from'      => 'required',
            'cbo_rack_no_from'      => 'required',
            'cbo_shelf_no_from'     => 'required',
            'cbo_bin_no_from'       => 'required',
            'cbo_location_to'       => 'required',
            'cbo_store_to'          => 'required',
            'cbo_floor_name_to'     => 'required',
            'cbo_room_no_to'        => 'required',
            'cbo_rack_no_to'        => 'required',
            'cbo_shelf_no_to'       => 'required',
            'cbo_bin_no_to'         => 'required',
        ]);

        DB::beginTransaction();
        try {

            if (empty($request->update_id)) {

                $system_no_info = generate_system_no(
                    $request->cbo_company_name,
                    '',
                    '',
                    date("Y"),
                    5,
                    "SELECT transfer_no_prefix,transfer_no_prefix_num from transfer_mst where company_id={$request->cbo_company_name} AND YEAR(created_at)=" . date('Y') . " order by transfer_no_prefix_num desc ",
                    "transfer_no_prefix",
                    "transfer_no_prefix_num"
                );

                $transferMaster = TransferMst::create([
                    'transfer_no_prefix' => $system_no_info->sys_no_prefix,
                    'transfer_no_prefix_num' => $system_no_info->sys_no_prefix_num,
                    'transfer_no' => $system_no_info->sys_no,
                    'company_id' => $request->cbo_company_name,
                    'transfer_date' => $request->txt_transfer_date,
                    'requisition_id' => $request->hidden_requisition_id
                ]);
            } else {
            }

            $params = [
                'product_id' => $request->hidden_product_id,
                'location_id' => $request->cbo_location_from,
                'store_id' => $request->cbo_store_from,
                'floor_id' => $request->cbo_floor_name_from,
                'room_id' => $request->cbo_room_no_from,
                'room_rack_id' => $request->cbo_rack_no_from,
                'room_self_id' => $request->cbo_shelf_no_from,
                'room_bin_id' => $request->cbo_bin_no_from
            ];

            $stock = calculate_current_stock($params);

            if ($stock->current_stock < $request->txt_transfer_qty) {
                throw new Exception('Transfer qty can not be greater than current stock');
            }

            $product_data = ProductDetailsMaster::find($request->hidden_product_id);

            // FROM transfer details
            InvTransaction::create([
                'mst_id' => $transferMaster->id,
                'transaction_type' => '6',
                'category_id' => $request->cbo_item_category,
                'product_id' => $request->hidden_product_id,
                'location_id' => $request->cbo_location_from,
                'store_id' => $request->cbo_store_from,
                'floor_id' => $request->cbo_floor_name_from,
                'room_id' => $request->cbo_room_no_from,
                'room_rack_id' => $request->cbo_rack_no_from,
                'room_self_id' => $request->cbo_shelf_no_from,
                'room_bin_id' => $request->cbo_bin_no_from,
                'order_uom' => $product_data->order_uom,
                'order_qnty' => $request->txt_transfer_qty * ($product_data->conversion_fac ?? 1),
                'order_rate' => round($product_data->avg_rate, 6),
                'order_amount' => round($request->txt_transfer_qty * ($product_data->avg_rate ?? 1), 6),
                'cons_uom' => $product_data->consuption_uom,
                'cons_qnty' => $request->txt_transfer_qty,
                'cons_rate' => round($product_data->avg_rate, 6),
                'cons_amount' => round($request->txt_transfer_qty * ($product_data->avg_rate ?? 1), 6)
            ]);

            // TO transfer details
            InvTransaction::create([
                'mst_id' => $transferMaster->id,
                'transaction_type' => '5',
                'category_id' => $request->cbo_item_category,
                'product_id' => $request->hidden_product_id,
                'location_id' => $request->cbo_location_to,
                'store_id' => $request->cbo_store_to,
                'floor_id' => $request->cbo_floor_name_to,
                'room_id' => $request->cbo_room_no_to,
                'room_rack_id' => $request->cbo_rack_no_to,
                'room_self_id' => $request->cbo_shelf_no_to,
                'room_bin_id' => $request->cbo_bin_no_to,
                'order_uom' => $product_data->order_uom,
                'order_qnty' => $request->txt_transfer_qty * ($product_data->conversion_fac ?? 1),
                'order_rate' => round($product_data->avg_rate, 6),
                'order_amount' => round($request->txt_transfer_qty * ($product_data->avg_rate ?? 1), 6),
                'cons_uom' => $product_data->consuption_uom,
                'cons_qnty' => $request->txt_transfer_qty,
                'cons_rate' => round($product_data->avg_rate, 6),
                'cons_amount' => round($request->txt_transfer_qty * ($product_data->avg_rate ?? 1), 6)
            ]);

            DB::commit();
            return response()->json([
                'code' => 0,
                'message' => 'Transfer Created Successfully',
                'data' => $transferMaster,
                'transfer_no' => $transferMaster->transfer_no,
                'id' => $transferMaster->id
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => $e->getMessage() . " in " . $e->getFile() . " at line " . $e->getLine()
            ]);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(TransferMst $transferMaster)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TransferMst $transferMaster)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, $update_id)
    {
        $request->validate([
            'cbo_company_name'      => 'required',
            'txt_transfer_date'     => 'required|date',
            'cbo_item_category'     => 'required',
            'hidden_product_id'     => 'required|integer',
            'txt_current_stock'     => 'required|numeric|min:1',
            'txt_avg_rate'          => 'required|numeric|min:1',
            'txt_transfer_qty'      => [
                'required',
                'numeric',
                'min:1',
                function ($attribute, $value, $fail) use ($request) {
                    if ($value > $request->txt_current_stock) {
                        $fail('The transfer quantity must not exceed the current stock.');
                    }
                }
            ],
            'cbo_location_from'     => 'required',
            'cbo_store_from'        => 'required',
            'cbo_floor_name_from'   => 'required',
            'cbo_room_no_from'      => 'required',
            'cbo_rack_no_from'      => 'required',
            'cbo_shelf_no_from'     => 'required',
            'cbo_bin_no_from'       => 'required',
            'cbo_location_to'       => 'required',
            'cbo_store_to'          => 'required',
            'cbo_floor_name_to'     => 'required',
            'cbo_room_no_to'        => 'required',
            'cbo_rack_no_to'        => 'required',
            'cbo_shelf_no_to'       => 'required',
            'cbo_bin_no_to'         => 'required',
        ]);

        DB::beginTransaction();
        try {
            // Update TransferMst
            $transferMaster = TransferMst::findOrFail($update_id);

            $transferMaster->update([
                'company_id' => $request->cbo_company_name,
                'transfer_date' => $request->txt_transfer_date,
                'requisition_id' => $request->hidden_requisition_id,
                // 'category_id' => $request->cbo_item_category,
                // 'product_id' => $request->hidden_product_id,
                // 'current_stock' => $request->txt_current_stock,
                // 'avg_rate' => $request->txt_avg_rate,
                // 'transfer_qty' => $request->txt_transfer_qty
            ]);


            $product_data = ProductDetailsMaster::find($request->hidden_product_id);

            // Update InvTransaction - FROM
            $transferFrom = InvTransaction::find($request->hidden_trans_from_id);

            $params = [
                'product_id' => $request->hidden_product_id,
                'location_id' => $request->cbo_location_from,
                'store_id' => $request->cbo_store_from,
                'floor_id' => $request->cbo_floor_name_from,
                'room_id' => $request->cbo_room_no_from,
                'room_rack_id' => $request->cbo_rack_no_from,
                'room_self_id' => $request->cbo_shelf_no_from,
                'room_bin_id' => $request->cbo_bin_no_from
            ];

            $stock = calculate_current_stock($params);

            if (($stock->current_stock - $transferFrom->cons_qnty) < $request->txt_transfer_qty) {
                throw new Exception('Transfer qty can not be greater than current stock');
            }

            if ($transferFrom) {
                $transferFrom->update([
                    'category_id' => $request->cbo_item_category,
                    'product_id' => $request->hidden_product_id,
                    'location_id' => $request->cbo_location_from,
                    'store_id' => $request->cbo_store_from,
                    'floor_id' => $request->cbo_floor_name_from,
                    'room_id' => $request->cbo_room_no_from,
                    'room_rack_id' => $request->cbo_rack_no_from,
                    'room_shelf_id' => $request->cbo_shelf_no_from,
                    'room_bin_id' => $request->cbo_bin_no_from,
                    'order_uom' => $product_data->order_uom,
                    'order_qnty' => $request->txt_transfer_qty * ($product_data->conversion_fac ?? 1),
                    'order_rate' => round($product_data->avg_rate, 6),
                    'order_amount' => round($request->txt_transfer_qty * ($product_data->avg_rate ?? 1), 6),
                    'cons_uom' => $product_data->consuption_uom,
                    'cons_qnty' => $request->txt_transfer_qty,
                    'cons_rate' => round($product_data->avg_rate, 6),
                    'cons_amount' => round($request->txt_transfer_qty * ($product_data->avg_rate ?? 1), 6)
                ]);
            }

            // Update InvTransaction - TO
            $transferTo = InvTransaction::find($request->hidden_trans_to_id);

            if ($transferTo) {
                $transferTo->update([
                    'category_id' => $request->cbo_item_category,
                    'product_id' => $request->hidden_product_id,
                    'location_id' => $request->cbo_location_to,
                    'store_id' => $request->cbo_store_to,
                    'floor_id' => $request->cbo_floor_name_to,
                    'room_id' => $request->cbo_room_no_to,
                    'room_rack_id' => $request->cbo_rack_no_to,
                    'room_shelf_id' => $request->cbo_shelf_no_to,
                    'room_bin_id' => $request->cbo_bin_no_to,
                    'order_uom' => $product_data->order_uom,
                    'order_qnty' => $request->txt_transfer_qty * ($product_data->conversion_fac ?? 1),
                    'order_rate' => round($product_data->avg_rate, 6),
                    'order_amount' => round($request->txt_transfer_qty * ($product_data->avg_rate ?? 1), 6),
                    'cons_uom' => $product_data->consuption_uom,
                    'cons_qnty' => $request->txt_transfer_qty,
                    'cons_rate' => round($product_data->avg_rate, 6),
                    'cons_amount' => round($request->txt_transfer_qty * ($product_data->avg_rate ?? 1), 6)
                ]);
            }

            DB::commit();
            return response()->json([
                'code' => 1,
                'message' => 'Transfer Updated Successfully',
                'data' => $transferMaster,
                'transfer_no' => $transferMaster->transfer_no,
                'id' => $transferMaster->id
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => $e->getMessage() . " in " . $e->getFile() . " at line " . $e->getLine()
            ]);
        }
    }


    /**
     * Remove the specified resource from storage.
     */

    public function destroy(TransferMst $transferMaster)
    {
        DB::beginTransaction();
        try {
            // Soft delete related InvTransaction
            InvTransaction::where('mst_id', $transferMaster->id)->delete();

            // Soft delete TransferMst
            $transferMaster->delete();

            DB::commit();
            return response()->json([
                'code' => 1,
                'message' => 'Transfer Deleted Successfully'
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => $e->getMessage() . " in " . $e->getFile() . " at line " . $e->getLine()
            ]);
        }
    }


    public function requisition_search_list_view(Request $request)
    {
        $param = $request->query('param') ?? '';
        return view('order_management.order.requisition_search_list_view', compact('param'));
    }

    public function transfer_item_list_view(Request $request)
    {
        $param = $request->query('param') ?? '';
        return view('order_management.order.transfer_item_list_view', compact('param'));
    }

    public function transfer_search_list_view(Request $request)
    {
        $param = $request->query('param') ?? '';
        return view('order_management.order.transfer_search_list_view', compact('param'));
    }

    public function load_transfer_mst_data($id)
    {
        $transfer = TransferMst::with(['requisition', 'product'])->find($id);

        if (!$transfer) {
            return response()->json(['code' => 404, 'message' => 'Transfer not found']);
        }

        return response()->json([
            'code' => 200,
            'data' => [
                'id' => $transfer->id,
                'transfer_no' => $transfer->transfer_no,
                'company_id' => $transfer->company_id,
                'transfer_date' => $transfer->transfer_date,
                'requisition_id' => $transfer->requisition_id,
                'requisition_no' => optional($transfer->requisition)->requisition_no,
                'category_id' => $transfer->category_id,
                'product_id' => $transfer->product_id,
                'item_description' => optional($transfer->product)->item_description,
                'current_stock' => $transfer->current_stock,
                'avg_rate' => $transfer->avg_rate,
                'transfer_qty' => $transfer->transfer_qty
            ]
        ]);
    }


    public function load_transfer_dtls($id)
    {
        $transferFrom = InvTransaction::where('mst_id', $id)
            ->where('transaction_type', 6)
            ->first();

        $transferTo = InvTransaction::where('mst_id', $id)
            ->where('transaction_type', 5)
            ->first();

        return view('order_management.order.transfer_dtls', compact('transferFrom', 'transferTo'));
    }

    public function requisition_dlts_list_view($requisition_id)
    {
        $requisition_dtls = RequisitionDtls::with(['product', 'category', 'uom'])
            ->where('mst_id', $requisition_id)
            ->get();

        return view('order_management.order.requisition_dtls_list', compact('requisition_dtls'));
    }

    public function calculateStock(Request $request)
    {
        $params = $request->all();
        $result = calculate_current_stock($params);
        return response()->json($result);
    }
}
