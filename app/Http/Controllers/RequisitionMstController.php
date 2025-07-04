<?php

namespace App\Http\Controllers;

use App\Models\RequisitionMst;
use App\Models\RequisitionDtls;
use Doctrine\DBAL\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RequisitionMstController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('order_management.order.requisition');
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
            'cbo_company_name' => 'required',
            'cbo_location_name' => 'required',
            'cbo_store_dept' => 'required',
            'cbo_store' => 'nullable',
            'cbo_department' => 'nullable',
            'txt_requisition_date' => 'required',
            'row_num' => 'required|integer|min:1'
        ]);

        //return response()->json(['error' => '','request'=>$request->all()]);

        DB::beginTransaction();
        try {
            // Generate system no for requisition

            $system_no_info = generate_system_no($request->cbo_company_name, '', 'REQ', date("Y", time()), 5, "SELECT requisition_no_prefix,requisition_no_prefix_num from requisition_mst where company_id={$request->cbo_company_name} AND YEAR(created_at)=" . date('Y', time()) . " order by requisition_no_prefix_num desc ", "requisition_no_prefix", "requisition_no_prefix_num");


            $requisitionMaster = RequisitionMst::create([
                'requisition_no_prefix' => $system_no_info->sys_no_prefix,
                'requisition_no_prefix_num' => $system_no_info->sys_no_prefix_num,
                'requisition_no' => $system_no_info->sys_no,
                'company_id' => $request->cbo_company_name,
                'location_id' => $request->cbo_location_name,
                'store_dept' => $request->cbo_store_dept,
                'store_id' => $request->cbo_store,
                'department_id' => $request->cbo_department,
                'requisition_date' => $request->txt_requisition_date,
            ]);

            // Insert requisition details
            $requisitionDetails = [];

            if (empty($request->row_num) && $request->row_num == 0) {
                throw new Exception("row not found");
            }

            for ($i = 1; $i <= $request->row_num; $i++) {
                if ($request["hidden_product_id_$i"] == null)
                    continue;
                $dtls_requisition = RequisitionDtls::create([
                    'mst_id' => $requisitionMaster->id,
                    'product_id' => $request["hidden_product_id_$i"],
                    'item_code' => $request["txt_item_code_$i"],
                    'category_id' => $request["cbo_item_category_$i"],
                    'uom' => $request["cbo_uom_$i"],
                    'requisition_qty' => $request["txt_requisition_qty_$i"]
                ]);
                $requisitionDetails[] = $dtls_requisition;
            }

            if (count($requisitionDetails) == 0) {
                throw new Exception("No product found");
            }

            DB::commit();
            return response()->json([
                'code' => 0,
                'message' => 'Requisition Created Successfully',
                'data' => $requisitionMaster,
                'requisition_no' => $requisitionMaster->requisition_no,
                'id' => $requisitionMaster->id
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage() . " in " . $e->getFile() . " at line " . $e->getLine()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(RequisitionMst $requisitionMaster)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RequisitionMst $requisitionMaster)
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
            'cbo_company_name' => 'required',
            'cbo_location_name' => 'required',
            'cbo_store_dept' => 'required',
            'cbo_store' => 'nullable',
            'cbo_department' => 'nullable',
            'txt_requisition_date' => 'required',
            'row_num' => 'required|integer|min:1'
        ]);
        DB::beginTransaction();
        try {
            // Find the requisition by ID
            $requistion_mst = RequisitionMst::findOrFail($update_id);
            if (!$requistion_mst) {
                throw new Exception("Requisition not found");
            }

            $requistion_mst->update([
                'company_id' => $request->cbo_company_name,
                'location_id' => $request->cbo_location_name,
                'store_dept' => $request->cbo_store_dept,
                'store_id' => $request->cbo_store,
                'department_id' => $request->cbo_department,
                'requisition_date' => $request->txt_requisition_date,
            ]);

            // Insert requisition details
            $requisitionDetails = [];

            if (empty($request->row_num) && $request->row_num == 0) {
                throw new Exception("row not found");
            }

            // Update requisition details
            for ($i = 1; $i <= $request->row_num; $i++) {
                if ($request->input("hidden_product_id_$i") == null) {
                    continue;
                }

                $dtlsId = $request->input("hidden_dtls_id_$i"); // Make sure you have this field
                $productId = $request->input("hidden_product_id_$i");

                if (empty($dtlsId)) {
                    // Create new record
                    $requisition_dtls = RequisitionDtls::create([
                        'mst_id' => $requistion_mst->id,
                        'product_id' => $productId,
                        'item_code' => $request["txt_item_code_$i"],
                        'category_id' => $request["cbo_item_category_$i"],
                        'uom' => $request["cbo_uom_$i"],
                        'requisition_qty' => $request["txt_requisition_qty_$i"]
                    ]);
                    $requisitionDetails[] = $requisition_dtls->id;
                } else {
                    // Update existing record
                    $requisition_dtls = RequisitionDtls::find($dtlsId);
                    if ($requisition_dtls) {
                        $requisition_dtls->update([
                            'product_id' => $productId,
                            'item_code' => $request["txt_item_code_$i"],
                            'category_id' => $request["cbo_item_category_$i"],
                            'uom' => $request["cbo_uom_$i"],
                            'requisition_qty' => $request["txt_requisition_qty_$i"]
                        ]);
                        $requisitionDetails[] = $requisition_dtls->id;
                    }
                }
            }

            if (count($requisitionDetails) == 0) {
                throw new Exception("No product found");
            }

            // Delete requisition details that are not in the updated list
            $existingDtlsIds = RequisitionDtls::where('mst_id', $requistion_mst->id)
                ->whereNotIn('id', $requisitionDetails)
                ->pluck('id');

            if (count($existingDtlsIds) > 0) {
                RequisitionDtls::whereIn('id', $existingDtlsIds)->delete();
            }

            DB::commit();
            return response()->json([
                'code' => 1,
                'message' => 'success',
                'data' => $requistion_mst,
                'requisition_no' => $requistion_mst->requisition_no,
                'id' => $requistion_mst->id
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try
        {
            $requisition_mst = RequisitionMst::findOrFail($id);

            $req_dtls = RequisitionDtls::with('transactions')->where('mst_id', $id)->get();

            foreach ($req_dtls as $dtls) {
                if ($dtls->transactions->count() > 0) {
                    throw new Exception("Issue Found. Delete or return related inventory transactions first.");
                }
                $dtls->delete();
            }

            $requisition_mst->delete();
            DB::commit();

            return response()->json(['status' => 'ok', 'message' => 'Delete Success','code' =>2], 200);
        }
        catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Delete failed. Please check related inventory transactions.',
                'code' => 10
            ], 400);
        }
    }


    public function requisition_item_list_view(Request $request)
    {
        $param = $request->query('param') ?? '';
        return view('order_management.order.item_search_list_view', compact('param'));
    }

    public function requisition_search_list_view(Request $request)
    {
        $param = $request->query('param') ?? '';
        return view('order_management.order.requisition_search_list_view', compact('param'));
    }

    public function requisition_details($id)
    {
        $requisition_dtls = RequisitionDtls::where('mst_id', $id)->get();
        return view('order_management.order.requisition_details', compact('requisition_dtls'));
    }
    public function req_details_from_issue($req_id)
    {
        $requisitions = RequisitionDtls::with('transactions')->where('mst_id', $req_id)->get();
        return view('order_management.order.req_details_from_issue', compact('requisitions'));
    }
}
