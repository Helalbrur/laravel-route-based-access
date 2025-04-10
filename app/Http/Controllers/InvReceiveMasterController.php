<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkOrderDtls;
use App\Models\InvReceiveMaster;

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
        //
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
