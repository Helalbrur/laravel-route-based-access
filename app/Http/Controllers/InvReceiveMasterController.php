<?php

namespace App\Http\Controllers;

use Doctrine\DBAL\Exception;
use Illuminate\Http\Request;
use App\Models\WorkOrderDtls;
use App\Models\InvTransaction;
use App\Models\VariableSetting;
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
            
            $settings = VariableSetting::select('id', 'over_receive')
                        ->where('variable_id', 3)
                        ->where('variable_value', 1)
                        ->where('variable_value', $request->cbo_company_name)
                        ->whereNull('deleted_at')
                        ->orderby('id', 'desc')
                        ->first();

            $over_receive = $settings->over_receive;
            // Generate system no for receive

            $system_no_info=generate_system_no( $request->cbo_company_name, '', 'GIR', date("Y",time()), 5, "SELECT sys_number_prefix,sys_number_prefix_num from inv_receive_master where company_id={$request->cbo_company_name} AND YEAR(created_at)=".date('Y',time())." order by sys_number_prefix_num desc ", "sys_number_prefix", "sys_number_prefix_num" );

            $all_product_arr = array();
            
            $invReceiveMaster = InvReceiveMaster::create([
                'sys_number_prefix' => $system_no_info->sys_no_prefix,
                'sys_number_prefix_num' => $system_no_info->sys_no_prefix_num,
                'sys_number' => $system_no_info->sys_no,
                'company_id' => $request->cbo_company_name,
                'location_id' => $request->cbo_location_name,
                'store_id' => $request->cbo_store_name,
                'receive_date' => $request->txt_receive_date,
                'work_order_no' => $request->txt_work_order_no,
                'work_order_id' => $request->work_order_id,
                'supplier_id' => $request->cbo_supplier,
                'receive_basis' => $request->cbo_receive_basis,
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

               
                // //dd($settings->pluck('over_receive')); 
                // $balance_qty = $receive_dtls_data[$request["hidden_work_order_detailsId_$i"]]['balance'];
                
                // if(!empty($over_receive) && $request->cbo_receive_basis == 3)
                // {
                //     $wo_dtls = WorkOrderDtls::find($request["hidden_work_order_detailsId_$i"]);
                //     if($wo_dtls == null) {
                //         throw new Exception("Work Order Details not found",111);
                //     }
                //     $balance_qty = $wo_dtls->balance;
                //     if($balance_qty == 0)
                //     {
                //         throw new Exception("Over Receive is not allowed",111);
                //     }
                //     if($wo_dtls->balance>0)
                //     {
                //         $over_receive_qty = ($balance_qty*$over_receive)/100;
                //         $txt_balanc_qty = $balance_qty + $over_receive_qty;
                //         if($request["txt_receive_qty_$i"] > $txt_balanc_qty)
                //         {
                //             throw new Exception("Over Receive is not allowed",111);
                //         }
                //     }else{
                //          throw new Exception("Over Receive is not allowed",111);
                //     }
                    
                // }
                // else if(empty($over_receive) && $request->cbo_receive_basis == 3)
                // {
                //     $wo_dtls = WorkOrderDtls::find($request["hidden_work_order_detailsId_$i"]);
                //     if($wo_dtls == null) {
                //         throw new Exception("Work Order Details not found",111);
                //     }
                //     $balance_qty = $wo_dtls->order_balance;
                //     if($balance_qty == 0)
                //     {
                //         throw new Exception("Over Receive is not allowed",111);
                //     }
                //     if($balance_qty>0)
                //     {
                //         $txt_balanc_qty = $balance_qty;
                //         if($request["txt_receive_qty_$i"] > $txt_balanc_qty)
                //         {
                //             throw new Exception("Over Receive is not allowed",111);
                //         }
                //     }else{
                //         $txt_work_order_qty = $request["txt_work_order_qty_$i"];
                //         if($request["txt_receive_qty_$i"] > $txt_work_order_qty)
                //         {
                //             throw new Exception("Over Receive is not allowed",111);
                //         }
                //     }
                // }
        

                $dtls_receive = InvTransaction::create([

                    $cons_qnty = $request["txt_receive_qty_$i"]*$request["hidden_conversion_fac_$i"],
                    $cons_rate = $request["txt_work_order_rate_$i"]*1,
                    $cons_amount = $cons_qnty*$cons_rate,

                    'mst_id' => $invReceiveMaster->id,
                    'transaction_type' => 1,
                    'location_id' => $request->cbo_location_name,
                    'store_id' => $request->cbo_store_name,
                    'product_id' => $request["hidden_product_id_$i"],
                    'order_uom' => $request["cbo_order_uom_$i"],
                    'order_qnty' => $request["txt_receive_qty_$i"], 
                    'order_rate' => $request["txt_work_order_rate_$i"],
                    'order_amount' => $request["txt_work_order_amount_$i"],
                    'lot' => $request["txt_lot_batch_no_$i"],
                    'expire_date' => $request["txt_expire_date_$i"], 
                    'date' => $request->txt_receive_date,
                    'floor_id' => $request["cbo_floor_name_$i"],
                    'room_id' => $request["cbo_room_no_$i"],
                    'room_rack_id' => $request["cbo_rack_no_$i"],
                    'room_self_id' => $request["cbo_shelf_no_$i"],
                    'room_bin_id' => $request["cbo_bin_no_$i"],
                    'cons_uom' => $request["hidden_consuption_uom_$i"],
                    'ref_dtls_id' => $request["hidden_work_order_detailsId_$i"],
                    'cons_qnty' => $cons_qnty,
                    'cons_rate' => $cons_rate,
                    'cons_amount' => $cons_amount,
                ]);
                $receiveDetails[] = $dtls_receive;
                $details_count++;
                $all_product_arr[$request["hidden_product_id_$i"]] = $request["hidden_product_id_$i"];
            }

            if(count($receiveDetails) == 0 || $details_count == 0)
            {
                throw new Exception("No product found",111);
            }
           
            DB::commit();
            $all_product_arr[$request["hidden_product_id_$i"]] = $request["hidden_product_id_$i"];

            foreach($all_product_arr as $product_id)
            {
                $product = ProductDetailsMaster::find($product_id);
                if (!empty($product->id))
                {
                    ProductDetailsMaster::updateProductInventory($product);
                }
            }
                
            return response()->json([
                'code'=>0,
                'message'=>'Receive Created Successfully',
                'data'=>$invReceiveMaster,
                'sys_number' => $invReceiveMaster->sys_number, 
                'id' => $invReceiveMaster->id
            ]);
           // return response()->json(['success' => 'Receive Created Successfully', 'sys_number' => $invReceiveMaster->sys_number, 'id' => $invReceiveMaster->id]);
        }
        catch (Exception $e)
        {
            DB::rollBack();
            return response()->json([
                'code'=>$e->getCode() ?? 10,
                'message'=>$e->getMessage(),
                'data'=>[],
                'sys_number' => '', 
                'id' =>''
            ],500);
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
                        
            $all_product_arr = array();

            // Find the work order by ID
            $invReceiveMaster = InvReceiveMaster::findOrFail($update_id);
            if(!$invReceiveMaster) {
                throw new Exception("Receive not found");
            }

            $invReceiveMaster->update([
                'company_id' => $request->cbo_company_name,
                'location_id' => $request->cbo_location_name,
                'store_id' => $request->cbo_store_name,
                'receive_date' => $request->txt_receive_date,
                'work_order_no' => $request->txt_work_order_no,
                'work_order_id' => $request->work_order_id,
                'supplier_id' => $request->cbo_supplier, 
                'receive_basis' => $request->cbo_receive_basis,
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
                        'location_id' => $request->cbo_location_name,
                        'store_id' => $request->cbo_store_name,
                        'transaction_type' => 1,
                        'order_uom' => $request["cbo_order_uom_$i"],
                        'order_qnty' => $request["txt_work_order_qty_$i"], 
                        'order_rate' => $request["txt_work_order_rate_$i"],
                        'order_amount' => $request["txt_work_order_amount_$i"],
                        'quantity' => $request["txt_receive_qty_$i"],
                        'lot' => $request["txt_lot_batch_no_$i"],
                        'expire_date' => $request["txt_expire_date_$i"],
                        'date' => $request->txt_receive_date,
                        'floor_id' => $request["cbo_floor_name_$i"],
                        'room_id' => $request["cbo_room_no_$i"],
                        'room_rack_id' => $request["cbo_rack_no_$i"],
                        'room_self_id' => $request["cbo_shelf_no_$i"],
                        'room_bin_id' => $request["cbo_bin_no_$i"],
                        'cons_uom' => $request["hidden_consuption_uom_$i"],
                        'ref_dtls_id' => $request["hidden_work_order_detailsId_$i"],
                        'cons_qnty' => $cons_qnty,
                        'cons_rate' => $cons_rate,
                        'cons_amount' => $cons_amount,
                    ]);
                    $receiveDetails[] = $dtls_receive->id;
                    $all_product_arr[$productId] = $productId;
                } else{

                    // Update existing record
                    $receive_dtls = InvTransaction::find($dtlsId);
                    if($receive_dtls == null) {
                        throw new Exception("Receive Details not found",111);
                    }

                    

                    // if(!empty($over_receive) && $request->cbo_receive_basis == 3)
                    // {
                    //     $wo_dtls = WorkOrderDtls::find($request["hidden_work_order_detailsId_$i"]);
                    //     if($wo_dtls == null) {
                    //         throw new Exception("Work Order Details not found",111);
                    //     }
                    //     $balance_qty = $wo_dtls->order_balance + $wo_dtls->order_balance;
                    //     if($balance_qty == 0)
                    //     {
                    //         throw new Exception("Over Receive is not allowed",111);
                    //     }
                    //     if($wo_dtls->order_balance>0)
                    //     {
                    //         $over_receive_qty = ($balance_qty*$over_receive)/100;
                    //         $txt_balanc_qty = $balance_qty + $over_receive_qty;
                    //         if($request["txt_receive_qty_$i"] > $txt_balanc_qty)
                    //         {
                    //             throw new Exception("Over Receive is not allowed",111);
                    //         }
                    //     }else{
                    //             throw new Exception("Over Receive is not allowed",111);
                    //     }
                        
                    // }
                    // else if(empty($over_receive) && $request->cbo_receive_basis == 3)
                    // {
                    //     $wo_dtls = WorkOrderDtls::find($request["hidden_work_order_detailsId_$i"]);
                    //     if($wo_dtls == null) {
                    //         throw new Exception("Work Order Details not found",111);
                    //     }
                    //     $balance_qty = $wo_dtls->balance;
                    //     if($balance_qty == 0)
                    //     {
                    //         throw new Exception("Over Receive is not allowed",111);
                    //     }
                    //     if($balance_qty>0)
                    //     {
                    //         $txt_balanc_qty = $balance_qty;
                    //         if($request["txt_receive_qty_$i"] > $txt_balanc_qty)
                    //         {
                    //             throw new Exception("Over Receive is not allowed",111);
                    //         }
                    //     }else{
                    //         $txt_work_order_qty = $request["txt_work_order_qty_$i"];
                    //         if($request["txt_receive_qty_$i"] > $txt_work_order_qty)
                    //         {
                    //             throw new Exception("Over Receive is not allowed",111);
                    //         }
                    //     }
                    // } 

                 
                    if($receive_dtls) {
                        $receive_dtls->update([

                            $cons_qnty = $request["txt_receive_qty_$i"]*$request["hidden_conversion_fac_$i"],
                            $cons_rate = $request["txt_work_order_rate_$i"]*1,
                            $cons_amount = $cons_qnty*$cons_rate,

                            'transaction_type' => 1,
                            'product_id' => $productId,
                            'order_uom' => $request["cbo_order_uom_$i"],
                            'order_qnty' => $request["txt_receive_qty_$i"], 
                            'order_rate' => $request["txt_work_order_rate_$i"],
                            'order_amount' => $request["txt_work_order_amount_$i"],
                            'lot' => $request["txt_lot_batch_no_$i"],
                            'expire_date' => $request["txt_expire_date_$i"],
                            'floor_id' => $request["cbo_floor_name_$i"],
                            'room_id' => $request["cbo_room_no_$i"],
                            'room_rack_id' => $request["cbo_rack_no_$i"],
                            'room_self_id' => $request["cbo_shelf_no_$i"],
                            'room_bin_id' => $request["cbo_bin_no_$i"],
                            'cons_uom' => $request["hidden_consuption_uom_$i"],
                             'ref_dtls_id' => $request["hidden_work_order_detailsId_$i"],
                            'cons_qnty' => $cons_qnty,
                            'cons_rate' => $cons_rate,
                            'cons_amount' => $cons_amount,
                        ]);
                        $receiveDetails[] = $receive_dtls->id;
                        $all_product_arr[$productId] = $productId;
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
   
            foreach($all_product_arr as $product_id)
            {
                $product = ProductDetailsMaster::find($product_id);
                if (!empty($product->id))
                {
                    ProductDetailsMaster::updateProductInventory($product);
                }
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
            return response()->json([
                'code'=>$e->getCode() ?? 10,
                'message'=>$e->getMessage(),
                'data'=>[],
                'sys_number' => '', 
                'id' =>''
            ],500);
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

        $work_dtls = DB::table('work_order_dtls as a')
            ->join('inv_transaction as b', 'a.id', '=', 'b.ref_dtls_id')
            ->where('b.transaction_type', 1)
            ->where('a.mst_id', $id)
            ->whereNull('a.deleted_at')
            ->whereNull('b.deleted_at')
            ->groupBy('a.id', 'a.quantity')
            ->select(
                'a.id',
                'a.quantity as work_order_quantity',
                DB::raw('SUM(b.order_qnty) as total_received'),
                DB::raw('a.quantity - SUM(b.order_qnty) as balance')
            )
            ->get();

        $work_dtls_data = [];
        foreach($work_dtls as $row)
        {
            $work_dtls_data[$row->id] = [
                'work_order_quantity' => $row->work_order_quantity,
                'total_received' => $row->total_received,
                'balance' => $row->balance
            ];
        }
        
        $orders = WorkOrderDtls::where('mst_id', $id)->get();
        return view('order_management.order.receive_work_order_details',compact('orders', 'work_dtls_data'));
    }


    public function receive_search_list_view(Request $request)
    {
        $param = $request->query('param') ?? '';
        return view('order_management.order.receive_search_list_view',compact('param'));
    }

    public function receive_details($id)
    {

        $work_dtls = DB::table('work_order_dtls as a')
            ->join('inv_transaction as b', 'a.id', '=', 'b.ref_dtls_id')
            ->where('b.transaction_type', 1)
            // ->where('b.mst_id', $id)
            ->whereNull('a.deleted_at')
            ->whereNull('b.deleted_at')
            ->groupBy('a.id', 'a.quantity')
            ->select(
                'a.id',
                'a.quantity as work_order_quantity',
                DB::raw('SUM(b.order_qnty) as total_received'),
                DB::raw('a.quantity - SUM(b.order_qnty) as balance')
            )
            ->get();
        //dd($work_dtls);

        $work_dtls_data = [];
        foreach($work_dtls as $row)
        {
            $work_dtls_data[$row->id] = [
                'work_order_quantity' => $row->work_order_quantity,
                'total_received' => $row->total_received,
                'balance' => $row->balance
            ];
        }

        $receives = InvTransaction::where('mst_id', $id)->get();
        return view('order_management.order.receive_details',compact('receives','work_dtls_data'));
    }

    public function receive_product_search_list_view(Request $request)
    {
        $param = $request->query('param') ?? '';
        return view('order_management.order.receive_product_search_list_view',compact('param'));
    }

    
}
