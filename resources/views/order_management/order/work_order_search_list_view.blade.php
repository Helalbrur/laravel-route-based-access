<?php
    $data = json_decode($param,true);

    
    $company_id     = $data['company_id'];
    $work_order_no  = $data['work_order_no'];
    $supplier_id    = $data['supplier_id'];
    $from_date      = $data['txt_from_date'];
    $to_date        = $data['txt_to_date'];
    
    $query_builder = App\Models\WorkOrderMst::query();
    if(!empty($company_id))
    {
        $query_builder = $query_builder->where('company_id', $company_id);
    }
    
    if(!empty($work_order_no))
    {
        $query_builder = $query_builder->where('wo_no' , 'like', '%'.trim($work_order_no).'%');
    }
    
    if(!empty($from_date) && !empty($to_date))
    {
        $query_builder = $query_builder->whereBetween('wo_date', [$from_date, $to_date]);
    }

    if(!empty($supplier_id))
    {
        $query_builder = $query_builder->where('supplier_id', $supplier_id);
    }
    
    $work_orders = $query_builder->get();
    
?>
<table id="list_view" class="table table-striped table-bordered" style="width: 100%">
    <thead>
        <tr>
            <th>Company</th>
            <th>Work Order</th>
            <th>Supplier</th>
            <th>Work Order Date</th>
        </tr>
    </thead>
    <tbody>
        <?php $sl = 1;?>
        @foreach($work_orders as $order)
            <?php 
                $sl++;
                $param = json_encode($order);
            ?>
            <tr id="tr_{{$order->id}}" onclick="js_set_value('{{ $param }}' )" style="cursor: pointer;" >
                <td>{{ get_all_company()[$order->company_id] ?? '' }}</td>
                <td>{{ $order->wo_no }}</td>
                <td>{{ get_all_supplier()[$order->supplier_id] ?? '' }}</td>
                <td>{{ $order->wo_date }}</td>
                
            </tr>
        @endforeach
    </tbody>
</table>