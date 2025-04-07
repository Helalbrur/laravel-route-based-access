@extends('layouts.popup')

@section('content')
<?php
$param = json_decode($param, true);
$supplier_id  = $param['supplier_id'] ?? '';
$category_id  = $param['category_id'] ?? '';
$brand_id     = $param['brand_id'] ?? '';
?>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Item Search</h5>
                <div class="card-text">
                    <input type="hidden" id="popup_value" name="popup_value" value="" />
                    <table id="list_view" class="table table-bordered" style="width: 100%">
                        <thead>
                            <tr>
                                <th width="20%">Supplier</th>
                                <th width="20%">Item Name</th>
                                <th width="20%">Category</th>
                                <th width="20%">Brand</th>
                                <th width="5%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <select name="cbo_supplier" id="cbo_supplier" class="form-control form-control-sm">
                                        <option value="0">SELECT</option>
                                        <?php $suppliers = App\Models\LibSupplier::pluck('supplier_name', 'id'); ?>
                                        @foreach($suppliers as $id => $supplier_name)
                                        <option value="{{ $id }}" {{ $id == $supplier_id ? 'selected' : '' }}>
                                            {{ $supplier_name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="text" class="form-control form-control-sm" id="txt_item_name" name="txt_item_name" value="" placeholder="Item Name">
                                </td>
                                <td>
                                    <select style="width: 100%" name="cbo_item_category" id="cbo_item_category" class="form-control form-control-sm">
                                        <?php $categories = App\Models\LibCategory::pluck('category_name', 'id'); ?>
                                        <option value="0">SELECT</option>
                                        @foreach($categories as $id => $category_name)
                                        <option value="{{ $id }}" {{ $id == $category_id ? 'selected' : '' }}>
                                            {{ $category_name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select name="cbo_brand" id="cbo_brand" class="form-control form-control-sm">
                                        <option value="0">SELECT</option>
                                        <?php $brands = App\Models\LibBrand::pluck('brand_name', 'id'); ?>
                                        @foreach($brands as $id => $brand_name)
                                        <option value="{{ $id }}" {{ $id == $brand_id ? 'selected' : '' }}>
                                            {{ $brand_name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-info"
                                        onclick="show_list_view( 
                                        JSON.stringify({
                                            supplier_id : document.getElementById('cbo_supplier').value,
                                            item_name : document.getElementById('txt_item_name').value,
                                            category_id : document.getElementById('cbo_item_category').value,
                                            brand_id : document.getElementById('cbo_brand').value
                                        }), 
                                        'tools/item_list_popup','search_div','','setFilterGrid(\'tbl_po_list\',-1)')">
                                        Show
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div id="search_div" class="mt-3"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    function js_set_value(param) {
        $('#popup_value').val(param);
        console.log(param);
        parent.emailwindow.hide();
    }
</script>
@endsection