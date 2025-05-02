<?php

namespace App\Http\Controllers;

use App\Models\WorkOrderDtls;
use App\Models\WorkOrderMst;
use Doctrine\DBAL\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WorkOrderMstController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('order_management.order.work_order');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'txt_work_order_date' => 'required',
            'cbo_company_name' => 'required',
            'cbo_supplier' => 'required',
            'cbo_pay_mode' => 'required',
            'cbo_location_name' => 'required',
            'row_num' => 'required|integer|min:1'
        ]);

        //return response()->json(['error' => '','request'=>$request->all()]);

        DB::beginTransaction();
        try
        {
            
            // Generate system no for work order

            $system_no_info=generate_system_no( $request->cbo_company_name, '', 'WO', date("Y",time()), 5, "SELECT wo_no_prefix,wo_no_prefix_num from work_order_mst where company_id={$request->cbo_company_name} AND YEAR(created_at)=".date('Y',time())." order by wo_no_prefix_num desc ", "wo_no_prefix", "wo_no_prefix_num" );

            
            $workOrderMst = WorkOrderMst::create([
                'wo_no_prefix' => $system_no_info->sys_no_prefix,
                'wo_no_prefix_num' => $system_no_info->sys_no_prefix_num,
                'wo_no' => $system_no_info->sys_no,
                'wo_date' => $request->txt_work_order_date,
                'delivery_date' => $request->txt_delivery_date,
                'company_id' => $request->cbo_company_name,
                'location_id' => $request->cbo_location_name,
                'supplier_id' => $request->cbo_supplier,
                'pay_mode' => $request->cbo_pay_mode,
                'source' => $request->cbo_source,
                'remarks' => $request->txt_remarks,
            ]);

            // Insert work order details
            $workOrderDetails = [];

            if(empty($request->row_num) && $request->row_num == 0)
            {
                throw new Exception("row not found");
            }

            for($i = 1; $i <= $request->row_num; $i++)
            {
                if($request["hidden_product_id_$i"] == null)
                    continue;
               $dtls_order = WorkOrderDtls::create([
                    'mst_id' => $workOrderMst->id,
                    'product_id' => $request["hidden_product_id_$i"],
                    'uom' => $request["cbo_uom_$i"],
                    'category_id' => $request["cbo_item_category_$i"],
                    'quantity' => $request["txt_work_order_qty_$i"],
                    'required_quantity' => $request["txt_required_qty_$i"],
                    'rate' => $request["txt_cur_rate_$i"],
                    'amount' => $request["txt_item_total_amount_$i"],
                    'date' => $request["txt_work_order_date"],
                    'remarks' => $request["txt_remarks"],
                ]);
                $workOrderDetails[] = $dtls_order;
            }

            if(count($workOrderDetails) == 0)
            {
                throw new Exception("No product found");
            }
           
            DB::commit();
            return response()->json([
                'code'=>0,
                'message'=>'Work Order Created Successfully',
                'data'=>$workOrderMst,
                'wo_no' => $workOrderMst->wo_no, 
                'id' => $workOrderMst->id
            ]);
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
    public function show(WorkOrderMst $workOrderMst)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WorkOrderMst $workOrderMst)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $update_id)
    {
        // Validate the request data
        $request->validate([
            'txt_work_order_date' => 'required',
            'cbo_company_name' => 'required',
            'cbo_supplier' => 'required',
            'cbo_pay_mode' => 'required',
            'cbo_location_name' => 'required',
            'row_num' => 'required|integer|min:1'
        ]);
        DB::beginTransaction();
        try
        {
            // Find the work order by ID
            $order = WorkOrderMst::findOrFail($update_id);
            if(!$order) {
                throw new Exception("Work Order not found");
            }
 
            $order->update([
                'wo_date' => $request->txt_work_order_date,
                'delivery_date' => $request->txt_delivery_date,
                'company_id' => $request->cbo_company_name,
                'location_id' => $request->cbo_location_name,
                'supplier_id' => $request->cbo_supplier,
                'pay_mode' => $request->cbo_pay_mode,
                'source' => $request->cbo_source,
                'remarks' => $request->txt_remarks,
            ]);

              // Insert work order details
            $workOrderDetails = [];

            if(empty($request->row_num) && $request->row_num == 0) {
                throw new Exception("row not found");
            }

            // Update work order details
            for($i = 1; $i <= $request->row_num; $i++) {
                if($request->input("hidden_product_id_$i") == null) {
                    continue;
                }
                
                $dtlsId = $request->input("hidden_dtls_id_$i"); // Make sure you have this field
                $productId = $request->input("hidden_product_id_$i");
                
                if(empty($dtlsId)) {
                    // Create new record
                    $order_dtls = WorkOrderDtls::create([
                        'mst_id' => $order->id,
                        'product_id' => $productId,
                        'uom' => $request["cbo_uom_$i"],
                        'category_id' => $request["cbo_item_category_$i"],
                        'quantity' => $request["txt_work_order_qty_$i"],
                        'required_quantity' => $request["txt_required_qty_$i"],
                        'rate' => $request["txt_cur_rate_$i"],
                        'amount' => $request["txt_item_total_amount_$i"],
                        'date' => $request["txt_work_order_date"],
                        'remarks' => $request["txt_remarks"],
                    ]);
                    $workOrderDetails[] = $order_dtls->id;
                } else {
                    // Update existing record
                    $order_dtls = WorkOrderDtls::find($dtlsId);
                    if($order_dtls) {
                        $order_dtls->update([
                            'product_id' => $productId,
                            'uom' => $request["cbo_uom_$i"],
                            'category_id' => $request["cbo_item_category_$i"],
                            'quantity' => $request["txt_work_order_qty_$i"],
                            'required_quantity' => $request["txt_required_qty_$i"],
                            'rate' => $request["txt_cur_rate_$i"],
                            'amount' => $request["txt_item_total_amount_$i"],
                            'date' => $request["txt_work_order_date"],
                            'remarks' => $request["txt_remarks"],
                        ]);
                        $workOrderDetails[] = $order_dtls->id;
                    }
                }
            }

            if(count($workOrderDetails) == 0) {
                throw new Exception("No product found");
            }

            // Delete work order details that are not in the updated list
            $existingDtlsIds = WorkOrderDtls::where('mst_id', $order->id)
                ->whereNotIn('id', $workOrderDetails)
                ->pluck('id');
                
            if(count($existingDtlsIds) > 0) {
                WorkOrderDtls::whereIn('id', $existingDtlsIds)->delete();
            }
            
            DB::commit();
            return response()->json([
                'code'=>1,
                'message'=>'success',
                'data'=>$order,
                'wo_no' => $order->wo_no, 
                'id' => $order->id
            ]);
        }
        catch (Exception $e)
        {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkOrderMst $workOrderMst)
    {
        //
    }

    public function product_search_list_view(Request $request)
    {
    
        $param = $request->query('param') ?? '';
        return view('order_management.order.product_search_list_view',compact('param'));
    }

    public function work_order_search_list_view(Request $request)
    {
        $param = $request->query('param') ?? '';
        return view('order_management.order.work_order_search_list_view',compact('param'));
    }

    public function work_order_details($id)
    {
        $orders = WorkOrderDtls::where('mst_id', $id)->get();
        return view('order_management.order.work_order_details',compact('orders'));
    }
}
