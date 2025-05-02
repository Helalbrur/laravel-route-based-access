<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\InvIssueMaster;
use App\Models\InvTransaction;
use Illuminate\Support\Facades\DB;
use App\Models\ProductDetailsMaster;
use Illuminate\Support\Facades\Auth;

class InvIssueMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('order_management.order.issue');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //($request->all());
        $request->validate([
            'cbo_company_name' => 'required',
            'cbo_issue_basis' => 'required',
            'cbo_location_name' => 'required',
            'txt_issue_date' => 'required',
            'row_num' => 'required|integer|min:1'
        ]);

        DB::beginTransaction();
        try
        {
            
            // Generate system no for receive

            $system_no_info=generate_system_no( $request->cbo_company_name, '', 'GIS', date("Y",time()), 5, "SELECT sys_number_prefix,sys_number_prefix_num from inv_issue_master where company_id={$request->cbo_company_name} AND YEAR(created_at)=".date('Y',time())." order by sys_number_prefix_num desc ", "sys_number_prefix", "sys_number_prefix_num" );

            $invIssueMaster = InvIssueMaster::create([
                'sys_number_prefix' => $system_no_info->sys_no_prefix,
                'sys_number_prefix_num' => $system_no_info->sys_no_prefix_num,
                'sys_number' => $system_no_info->sys_no,
                'company_id' => $request->cbo_company_name,
                'location_id' => $request->cbo_location_name,
                'store_id' => $request->cbo_store_name,
                'date' => $request->txt_issue_date,
                'requisition_no' => $request->txt_requisition_no,
                'requisition_id' => $request->requisition_id,
                'issue_basis' => $request->cbo_issue_basis,
                'remarks' => $request->txt_remarks,
                'created_at' => now(),
                'created_by' => Auth::id(),
            ]);

            // Insert receive details
            $issueDetails = [];

            if(empty($request->row_num) && $request->row_num == 0)
            {
                throw new Exception("row not found");
            }

            $details_count = 0;
            for($i = 1; $i <= $request->row_num; $i++)
            {
                
                $product_id = $request["hidden_product_id_$i"];
                if(empty($product_id))
                { 
                    throw new Exception("Product not found"); 
                }

                $product = ProductDetailsMaster::findOrFail($product_id);

                $cons_qnty = $request["txt_issue_qty_$i"];
                $order_qnty = $cons_qnty;
                $cons_rate = $request["txt_cur_rate_$i"]*1;
                $cons_amount = $cons_qnty*$cons_rate;

                $dtls_issue = InvTransaction::create([
                    'mst_id' => $invIssueMaster->id,
                    'transaction_type' => 2,
                    'product_id' => $product_id,
                    'order_uom' => $product->order_uom ?? $request["cbo_order_uom_$i"],
                    'order_qnty' => $order_qnty, 
                    'order_rate' => $cons_rate,
                    'order_amount' => $cons_amount,
                    'lot' => $request["txt_lot_batch_no_$i"],
                    'expire_date' => $request["txt_expire_date_$i"],
                    'floor_id' => $request["cbo_floor_name_$i"],
                    'room_id' => $request["cbo_room_no_$i"],
                    'room_rack_id' => $request["cbo_rack_no_$i"],
                    'room_self_id' => $request["cbo_shelf_no_$i"],
                    'room_bin_id' => $request["cbo_bin_no_$i"],
                    'cons_uom' => $product->cons_uom ?? $request["hidden_consuption_uom_$i"],
                    'cons_qnty' => $cons_qnty,
                    'cons_rate' => $cons_rate,
                    'cons_amount' => $cons_amount,
                    'ref_dtls_id' => $request["req_dtls_id_$i"]
                ]);
                $issueDetails[] = $dtls_issue;
                $details_count++;
            }

            if(count($issueDetails) == 0 || $details_count == 0)
            {
                throw new Exception("No product found");
            }
           
            DB::commit();
            return response()->json([
                'code'=>0,
                'message'=>'Receive Created Successfully',
                'data'=>$invIssueMaster,
                'sys_number' => $invIssueMaster->sys_number, 
                'id' => $invIssueMaster->id
            ]);
            return response()->json(['success' => 'Issue Created Successfully', 'sys_number' => $invIssueMaster->sys_number, 'id' => $invIssueMaster->id]);
        }
        catch (Exception $e)
        {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()." in ".$e->getFile()." at line ".$e->getLine()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(InvIssueMaster $invIssueMaster)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InvIssueMaster $invIssueMaster)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'cbo_company_name' => 'required',
            'cbo_issue_basis' => 'required',
            'cbo_location_name' => 'required',
            'txt_issue_date' => 'required',
            'row_num' => 'required|integer|min:1'
        ]);

        DB::beginTransaction();
        try {
            $invIssueMaster = InvIssueMaster::findOrFail($id);

            $invIssueMaster->update([
                'company_id' => $request->cbo_company_name,
                'location_id' => $request->cbo_location_name,
                'store_id' => $request->cbo_store_name,
                'date' => $request->txt_issue_date,
                'requisition_no' => $request->txt_requisition_no,
                'requisition_id' => $request->requisition_id,
                'issue_basis' => $request->cbo_issue_basis,
                'remarks' => $request->txt_remarks,
                'updated_at' => now(),
                'updated_by' => Auth::id(),
            ]);

            $details_count = 0;
            for ($i = 1; $i <= $request->row_num; $i++) {
                $product_id = $request["hidden_product_id_$i"];
                if (empty($product_id)) {
                    throw new Exception("Product not found");
                }

                $cons_qnty = $request["txt_issue_qty_$i"];
                $cons_rate = $request["txt_cur_rate_$i"] * 1;
                $cons_amount = $cons_qnty * $cons_rate;

                $detail_data = [
                    'mst_id' => $invIssueMaster->id,
                    'transaction_type' => 2,
                    'product_id' => $product_id,
                    'order_qnty' => $cons_qnty,
                    'order_rate' => $cons_rate,
                    'order_amount' => $cons_amount,
                    'lot' => $request["txt_lot_batch_no_$i"],
                    'expire_date' => $request["txt_expire_date_$i"],
                    'floor_id' => $request["cbo_floor_name_$i"],
                    'room_id' => $request["cbo_room_no_$i"],
                    'room_rack_id' => $request["cbo_rack_no_$i"],
                    'room_self_id' => $request["cbo_shelf_no_$i"],
                    'room_bin_id' => $request["cbo_bin_no_$i"],
                    'cons_qnty' => $cons_qnty,
                    'cons_rate' => $cons_rate,
                    'cons_amount' => $cons_amount,
                    'order_uom' => $product->order_uom ?? $request["cbo_order_uom_$i"],
                    'cons_uom' => $product->cons_uom ?? $request["hidden_consuption_uom_$i"],
                    'ref_dtls_id' => $request["req_dtls_id_$i"]
                ];

                $dtlsId = $request->input("hidden_dtls_id_$i");
                if ($dtlsId) {
                    // Update existing detail
                    $transaction = InvTransaction::findOrFail($dtlsId);
                    $transaction->update($detail_data);
                } else {
                    // Insert new detail
                    InvTransaction::create($detail_data);
                }

                $details_count++;
            }

            if ($details_count == 0) {
                throw new Exception("No product found");
            }

            DB::commit();
            return response()->json([
                'code' => 0,
                'message' => 'Issue Updated Successfully',
                'data' => $invIssueMaster,
                'sys_number' => $invIssueMaster->sys_number,
                'id' => $invIssueMaster->id
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
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $invIssueMaster = InvIssueMaster::findOrFail($id);

            // Delete related transactions
            InvTransaction::where('mst_id', $invIssueMaster->id)->delete();

            // Delete master record
            $invIssueMaster->delete();

            DB::commit();
            return response()->json([
                'code' => 0,
                'message' => 'Issue deleted successfully'
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => $e->getMessage() . " in " . $e->getFile() . " at line " . $e->getLine()
            ]);
        }
    }

    /**
     * Return the view for showing the details of a given issue
     *
     * @param int $id The ID of the issue master record
     * @return \Illuminate\Http\Response
     */
    public function isssue_details($id)
    {
        $trans = InvTransaction::where('mst_id', $id)->get();
        return view('order_management.order.isssue_details',compact('trans'));
    }
}
