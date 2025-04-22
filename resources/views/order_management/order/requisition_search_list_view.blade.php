<?php
$data = json_decode($param, true);

$company_id     = $data['company_id'];
$requisition_no = $data['requisition_no'];
$store_id       = $data['store_id'];
$department_id  = $data['department_id'];
$from_date      = $data['txt_from_date'];
$to_date        = $data['txt_to_date'];

$query_builder = App\Models\RequisitionMst::query();
if (!empty($company_id)) {
    $query_builder = $query_builder->where('company_id', $company_id);
}

if (!empty($requisition_no)) {
    $query_builder = $query_builder->where('requisition_no', 'like', '%' . trim($requisition_no) . '%');
}

if (!empty($supplier_id)) {
    $query_builder = $query_builder->where('store_id', $store_id);
}

if (!empty($supplier_id)) {
    $query_builder = $query_builder->where('department_id', $department_id);
}

if (!empty($from_date) && !empty($to_date)) {
    $query_builder = $query_builder->whereBetween('requisition_date', [$from_date, $to_date]);
}

$requisitions = $query_builder->get();

?>
<table id="list_view" class="table table-striped table-bordered" style="width: 100%">
    <thead>
        <tr>
            <th>Company</th>
            <th>Requisition</th>
            <th>Store</th>
            <th>Department</th>
            <th>Requisition Date</th>
        </tr>
    </thead>
    <tbody>
        <?php $sl = 1; ?>
        @foreach($requisitions as $requisition)
        <?php
        $sl++;
        $param = json_encode($requisition);
        ?>
        <tr id="tr_{{$requisition->id}}" onclick="js_set_value('{{ $param }}' )" style="cursor: pointer;" class="{{ $class }}">
            <td>{{ get_all_company()[$requisition->company_id] ?? '' }}</td>
            <td>{{ $requisition->requisition_no }}</td>
            <td>{{ get_all_store()[$requisition->store_id] ?? '' }}</td>
            <td>{{ get_all_department()[$requisition->department_id_id] ?? '' }}</td>
            <td>{{ $requisition->requisition_date }}</td>
        </tr>
        @endforeach
    </tbody>
</table>