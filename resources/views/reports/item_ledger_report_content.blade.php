<?php
$product_data = [];
$product_details = [];
foreach ($transactions as $row) {
    // Fix 1: Add null coalescing for array access
    $uom = get_uom()[$row->uom] ?? 'N/A';
    $product_details[$row->product_id] = 'Product Id: '.$row->product_id.', Item Name:'.$row->item_description .', UOM:'. $uom;
    $product_data[$row->product_id][] = $row;
}
?>
<table>
    <tr>
        <td>
            <input type="button" name="print" class="formbutton btn btn-sm btn-info" value="Print" onClick="print_preview()" title="Click to Print" style="width:70px;" />
        </td>
        <td>
            <input type="button" name="excel" class="formbutton btn btn-sm btn-info" value="Download Excel" onClick="excel_download()" title="Click to Print" style="width:70px;" />
        </td>
    </tr>
</table>

<div style="width:100%;" id="item_ledger_report">
    <table class="table table-bordered table-striped" id="item_ledger_report_table" style="width:100%" border="1" cellpadding="0" cellspacing="0" >
        <thead>
            <tr>
                <th rowspan="2" width="3%">Sl</th>
                <th rowspan="2" width="9%">Store Name</th>
                <th rowspan="2" width="7%">Trans Date</th>
                <th rowspan="2" width="9%">Trans Ref No</th>
                <th colspan="3" width="24%">Receive</th>
                <th colspan="3" width="24%">Issue</th>
                <th colspan="3">Balance</th>
            </tr>
            <tr>
                <th width="8%">Qnty</th>
                <th width="8%">Rate</th>
                <th width="8%">Value</th>
                <th width="8%">Qnty</th>
                <th width="8%">Rate</th>
                <th width="8%">Value</th>
                <th width="8%">Qnty</th>
                <th width="8%">Rate</th>
                <th>Value</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($product_data as $product_id => $prod_rows) : ?>
                <tr>
                    <td colspan="17"><b><?= $product_details[$product_id] ?? '' ?></b></td>
                </tr>
                <?php 
                $i = 1;
                foreach ($prod_rows as $row) : 
                    // Fix 2: Handle missing store_id
                    $store = get_all_store()[$row->store_id ?? 0] ?? 'N/A';
                    
                    // Fix 3: Separate receive/issue values
                    $receive_qty = $row->transaction_type === 'Receipt' ? $row->quantity : 0;
                    $issue_qty = $row->transaction_type === 'Issue' ? abs($row->quantity) : 0;
                ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= $store ?></td>
                        <td><?= $row->transaction_date ?></td>
                        <td><?= $row->sys_number ?></td>
                        
                        <!-- Receipt Columns -->
                        <td><?= number_format($receive_qty, 4) ?></td>
                        <td><?= $receive_qty ? number_format($row->rate, 2) : '' ?></td>
                        <td><?= $receive_qty ? number_format($row->amount, 2) : '' ?></td>
                        
                        <!-- Issue Columns -->
                        <td><?= number_format($issue_qty, 4) ?></td>
                        <td><?= $issue_qty ? number_format($row->rate, 2) : '' ?></td>
                        <td><?= $issue_qty ? number_format($row->amount, 2) : '' ?></td>
                        
                        <!-- Balance Columns -->
                        <td><?= number_format($row->balance, 4) ?></td>
                        <td><?= $row->quantity > 0 ? number_format($row->amount / $row->quantity, 6) : '0.000000' ?></td>
                        <td><?= number_format($row->balance * $row->rate, 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>    
        </tbody>
    </table>
</div>
