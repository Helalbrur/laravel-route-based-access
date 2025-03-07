<?php

namespace App\Http\Controllers;

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
        $this->request->validate([
            'wo_date' => 'required',
            'delivery_date' => 'required',
            'cbo_company_name' => 'required',
            'cbo_supplier_name' => 'required',
            'pay_mode' => 'required'
        ]);

        DB::beginTransaction();
        try
        {
            /*
            // Generate system no for work order

            $system_no_info=generate_system_no( $request->cbo_company_name, '', '', date("Y",time()), 5, "SELECT wo_no_prefix,wo_no_prefix_num from work_order_mst where compnay_id={$request->cbo_company_name} AND YEAR(wo_date)=".date('Y',time())." order by wo_no_prefix_num desc ", "wo_no_prefix", "wo_no_prefix_num" );

            
            $workOrderMst = WorkOrderMst::create([
                'wo_no_prefix' => $system_no_info['wo_no_prefix'],
                'wo_no_prefix_num' => $system_no_info['wo_no_prefix_num'],
                'wo_no' => $system_no_info['wo_no'],
                'wo_date' => $request->wo_date,
                'delivery_date' => $request->delivery_date,
                'company_id' => $request->cbo_company_name,
                'supplier_id' => $request->cbo_supplier_name,
                'pay_mode' => $request->pay_mode,
                'source' => $request->source,
                'remarks' => $request->remarks,
            ]);
            */
            DB::commit();
            return response()->json(['success' => 'Work Order Created Successfully']);
        }
        catch (Exception $e)
        {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()]);
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
    public function update(Request $request, WorkOrderMst $workOrderMst)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkOrderMst $workOrderMst)
    {
        //
    }
}
