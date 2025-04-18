<?php

namespace App\Http\Controllers;

use Doctrine\DBAL\Exception;
use Illuminate\Http\Request;
use App\Models\WorkOrderDtls;
use App\Models\InvTransaction;
use App\Models\InvReceiveMaster;
use Illuminate\Support\Facades\DB;
use App\Models\ProductDetailsMaster;
use Illuminate\Support\Facades\Auth;

class InvReceiveMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('order_management.order.receive_entry');
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
            'cbo_supplier' => 'required',
            'cbo_location_name' => 'required',
            'txt_receive_date' => 'required',
            'row_num' => 'required|integer|min:1'
        ]);

        DB::beginTransaction();
        try
        {
            
            // Generate system no for receive

            $system_no_info=generate_system_no( $request->cbo_company_name, '', '', date("Y",time()), 5, "SELECT sys_number_prefix,sys_number_prefix_num from inv_receive_master where company_id={$request->cbo_company_name} AND YEAR(created_at)=".date('Y',time())." order by sys_number_prefix_num desc ", "sys_number_prefix", "sys_number_prefix_num" );
            
            $invReceiveMaster = InvReceiveMaster::create([
                'sys_number_prefix' => $system_no_info->sys_no_prefix,
                'sys_number_prefix_num' => $system_no_info->sys_no_prefix_num,
                'sys_number' => $system_no_info->sys_no,
                'company_id' => $request->cbo_company_name,
                'location_id' => $request->cbo_location_name,
                'store_id' => $request->cbo_store,
                'receive_date' => $request->txt_receive_date,
                'work_order_no' => $request->txt_work_order_no,
                'work_order_id' => $request->work_order_id,
                'supplier_id' => $request->cbo_supplier,
                'created_at' => now(),
                'created_by' => Auth::id(),
            ]);

            // Insert receive details
            $receiveDetails = [];

            if(empty($request->row_num) && $request->row_num == 0)
            {
                throw new Exception("row not found");
            }

            $details_count = 0;
            for($i = 1; $i <= $request->row_num; $i++)
            {
                //throw new Exception($request["hidden_product_id_$i"]);

                $dtls_receive = InvTransaction::create([

                    $cons_qnty = $request["txt_work_order_qty_$i"]*$request["hidden_conversion_fac_$i"],
                    $cons_rate = $request["txt_work_order_rate_$i"]*1,
                    $cons_amount = $cons_qnty*$cons_rate,

                    'mst_id' => $invReceiveMaster->id,
                    'transaction_type' => 1,
                    'product_id' => $request["hidden_product_id_$i"],
                    'order_uom' => $request["cbo_order_uom_$i"],
                    'order_qnty' => $request["txt_work_order_qty_$i"], 
                    'order_rate' => $request["txt_work_order_rate_$i"],
                    'order_amount' => $request["txt_work_order_amount_$i"],
                    'quantity' => $request["txt_receive_qty_$i"],
                    'lot' => $request["txt_lot_batch_no_$i"],
                    'expire_date' => $request["txt_expire_date_$i"],
                    'room_rack_id' => $request["cbo_rack_no_$i"],
                    'room_self_id' => $request["cbo_shelf_no_$i"],
                    'room_bin_id' => $request["cbo_bin_no_$i"],
                    'cons_uom' => $request["hidden_consuption_uom_$i"],
                    'cons_qnty' => $cons_qnty,
                    'cons_rate' => $cons_rate,
                    'cons_amount' => $cons_amount,
                ]);
                $receiveDetails[] = $dtls_receive;
                $details_count++;
            }

            if(count($receiveDetails) == 0 || $details_count == 0)
            {
                throw new Exception("No product found");
            }
           
            DB::commit();
            return response()->json([
                'code'=>0,
                'message'=>'Receive Created Successfully',
                'data'=>$invReceiveMaster,
                'sys_number' => $invReceiveMaster->sys_number, 
                'id' => $invReceiveMaster->id
            ]);
            return response()->json(['success' => 'Receive Created Successfully', 'sys_number' => $invReceiveMaster->sys_number, 'id' => $invReceiveMaster->id]);
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
    public function show(InvReceiveMaster $invReceiveMaster)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InvReceiveMaster $invReceiveMaster)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $update_id)
    {
          //($request->all());
          $request->validate([
            'cbo_company_name' => 'required',
            'cbo_supplier' => 'required',
            'cbo_location_name' => 'required',
            'txt_receive_date' => 'required',
            'row_num' => 'required|integer|min:1'
        ]);

        DB::beginTransaction();
        try
        {
                        
            // Find the work order by ID
            $invReceiveMaster = InvReceiveMaster::findOrFail($update_id);
            if(!$invReceiveMaster) {
                throw new Exception("Receive not found");
            }

            $invReceiveMaster->update([
                'company_id' => $request->cbo_company_name,
                'location_id' => $request->cbo_location_name,
                'store_id' => $request->cbo_store,
                'receive_date' => $request->txt_receive_date,
                'work_order_no' => $request->txt_work_order_no,
                'work_order_id' => $request->work_order_id,
                'supplier_id' => $request->cbo_supplier,
            ]);

            // Insert receive details
            $receiveDetails = [];

            if(empty($request->row_num) && $request->row_num == 0)
            {
                throw new Exception("row not found");
            }

            for($i = 1; $i <= $request->row_num; $i++)
            {
                if($request->input("hidden_product_id_$i") == null) {
                    continue;
                }
                $dtlsId = $request->input("hidden_dtls_id_$i"); // Make sure you have this field
                $productId = $request->input("hidden_product_id_$i");

                if(empty($dtlsId)){
                    $dtls_receive = InvTransaction::create([

                        $cons_qnty = $request["txt_work_order_qty_$i"]*$request["hidden_conversion_fac_$i"],
                        $cons_rate = $request["txt_work_order_rate_$i"]*1,
                        $cons_amount = $cons_qnty*$cons_rate,

                        'mst_id' => $invReceiveMaster->id,
                        'product_id' => $productId,
    
                        'transaction_type' => 1,
                        'order_uom' => $request["cbo_order_uom_$i"],
                        'order_qnty' => $request["txt_work_order_qty_$i"], 
                        'order_rate' => $request["txt_work_order_rate_$i"],
                        'order_amount' => $request["txt_work_order_amount_$i"],
                        'quantity' => $request["txt_receive_qty_$i"],
                        'lot' => $request["txt_lot_batch_no_$i"],
                        'expire_date' => $request["txt_expire_date_$i"],
                        'room_rack_id' => $request["cbo_rack_no_$i"],
                        'room_self_id' => $request["cbo_shelf_no_$i"],
                        'room_bin_id' => $request["cbo_bin_no_$i"],
                        'cons_uom' => $request["hidden_consuption_uom_$i"],
                        'cons_qnty' => $cons_qnty,
                        'cons_rate' => $cons_rate,
                        'cons_amount' => $cons_amount,
                    ]);
                    $receiveDetails[] = $dtls_receive->id;
                } else{

                    // Update existing record
                    $receive_dtls = InvTransaction::find($dtlsId);
                    if($receive_dtls) {
                        $receive_dtls->update([

                            $cons_qnty = $request["txt_work_order_qty_$i"]*$request["hidden_conversion_fac_$i"],
                            $cons_rate = $request["txt_work_order_rate_$i"]*1,
                            $cons_amount = $cons_qnty*$cons_rate,

                            'transaction_type' => 1,
                            'product_id' => $productId,
                            'order_uom' => $request["cbo_order_uom_$i"],
                            'order_qnty' => $request["txt_work_order_qty_$i"], 
                            'order_rate' => $request["txt_work_order_rate_$i"],
                            'order_amount' => $request["txt_work_order_amount_$i"],
                            'quantity' => $request["txt_receive_qty_$i"],
                            'lot' => $request["txt_lot_batch_no_$i"],
                            'expire_date' => $request["txt_expire_date_$i"],
                            'room_rack_id' => $request["cbo_rack_no_$i"],
                            'room_self_id' => $request["cbo_shelf_no_$i"],
                            'room_bin_id' => $request["cbo_bin_no_$i"],
                            'cons_uom' => $request["hidden_consuption_uom_$i"],
                            'cons_qnty' => $cons_qnty,
                            'cons_rate' => $cons_rate,
                            'cons_amount' => $cons_amount,
                        ]);
                        $receiveDetails[] = $receive_dtls->id;
                    }
                }
            }

            if(count($receiveDetails) == 0 )
            {
                throw new Exception("No product found");
            }

            // Delete receive details that are not in the updated list
            $existingDtlsIds = InvTransaction::where('mst_id', $invReceiveMaster->id)
            ->whereNotIn('id', $receiveDetails)
            ->pluck('id');
               
            if(count($existingDtlsIds) > 0) {
                InvTransaction::whereIn('id', $existingDtlsIds)->delete();
            }
   

            DB::commit();
            return response()->json([
                'code'=>1,
                'message'=>'success',
                'data'=>$invReceiveMaster,
                'sys_number' => $invReceiveMaster->sys_number, 
                'id' => $invReceiveMaster->id
            ]);

        }
        catch (Exception $e)
        {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()." in ".$e->getFile()." at line ".$e->getLine()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InvReceiveMaster $invReceiveMaster)
    {
        //
    }

    public function receive_work_order_search_list_view(Request $request)
    {
        $param = $request->query('param') ?? '';
        return view('order_management.order.receive_work_order_search_list_view',compact('param'));
    }

    public function receive_work_order_details($id)
    {
        $orders = WorkOrderDtls::where('mst_id', $id)->get();
        return view('order_management.order.receive_work_order_details',compact('orders'));
    }


    public function receive_search_list_view(Request $request)
    {
        $param = $request->query('param') ?? '';
        return view('order_management.order.receive_search_list_view',compact('param'));
    }

    public function receive_details($id)
    {
        $receives = InvTransaction::where('mst_id', $id)->get();
        return view('order_management.order.receive_details',compact('receives'));
    }

    
}
