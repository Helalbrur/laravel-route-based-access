<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkOrderDtls;
use App\Models\InvTransaction;
use App\Models\InvReceiveMaster;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Doctrine\DBAL\Exception;

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

            for($i = 1; $i <= $request->row_num; $i++)
            {
            
               $dtls_receive = InvTransaction::create([
                    'mst_id' => $invReceiveMaster->id,
                    'transaction_type' => 1,
                    'product_id' => $request["hidden_product_id_$i"],
                    'required_qty' => $request["txt_required_qty_$i"],
                    'work_order_qty' => $request["txt_work_order_qty_$i"],
                    'quantity' => $request["txt_receive_qty_$i"],
                    'lot' => $request["txt_lot_batch_no_$i"],
                    'expire_date' => $request["txt_expire_date_$i"],
                    'room_rack_id' => $request["cbo_rack_no_$i"],
                    'room_self_id' => $request["cbo_shelf_no_$i"],
                    'room_bin_id' => $request["cbo_bin_no_$i"],
                ]);
                $receiveDetails[] = $dtls_receive;
            }

            if(count($receiveDetails) == 0)
            {
                throw new Exception("No product found");
            }
           
            DB::commit();
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
    public function update(Request $request, InvReceiveMaster $invReceiveMaster)
    {
        //
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
}
