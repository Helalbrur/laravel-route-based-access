@extends('layouts.popup')

@section('content')
<?php
$param = json_decode($param,true);
$supplier_id        = $param['supplier_id'] ?? '';
$item_id            = $param['item_id'] ?? '';
$item_name          = $param['item_name'] ?? '';
$item_code          = $param['item_code'] ?? '';
$cbo_category_id    = $param['category_id'] ?? 0;
?>
<div class="row">
    <div class="col-lg-10">
        <div class="card">
            <div class="card-body">

                <h5 class="card-title">Item Search</h5>
                <div class="card-text">
                    <input type="hidden" id="popup_value" name="popup_value" value="" />
                    <table id="list_view" class="table table-striped" style="width: 100%">
                        <thead>
                            <tr>
                                
                                <th width ="15%">Item Category</th>
                                <th width ="15%">Item Name</th>
                                <th width ="15%">Item Code</th>
                                <th width ="15%">Origin</th>
                                <th width ="15%">Generic Name</th>
                                <th width ="10%">Re Order Level</th>
                                <th>

                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <select class="form-control form-control-sm" id="cbo_item_category" name="cbo_item_category" style="width: 100%" 
                                            onchange="handleCategoryChange()">
                                        <option value="">--All--</option>
                                        @foreach(get_item_category() as $category_id => $category_name)
                                            <option value="{{$category_id}}" {{ ($category_id == $cbo_category_id) ? 'selected' : '' }}>{{$category_name}}</option>
                                        @endforeach
                                    </select>
                                </td>

                                <td id="product_div">
                                    <select class="form-control form-control-sm" id="cbo_product" name="cbo_product" style="width: 100%">
                                        <option value="">--All--</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" class="form-control form-control-sm" id="txt_item_code" name="txt_item_code" value="{{$item_code}}" placeholder="Item Code">
                                </td>
                                <td>
                                    <input type="text" class="form-control form-control-sm" id="txt_origin" name="txt_origin"  placeholder="Origin">
                                </td>
                                <td>
                                    <select class="form-control form-control-sm" id="cbo_generic_name" name="cbo_generic_name" style="width: 100%" >
                                        <option value="">--All--</option>
                                        @foreach(get_generic_name() as $generic_id => $generic_name)
                                            <option value="{{$generic_id}}" >{{$generic_name}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="checkbox" id="txt_reorder_level" class="form-control form-control-sm" name="txt_reorder_level" value="0" onclick="check_uncheck()"  />
                                </td>
                                <td>
                                    
                                    <input type="button" name="button2" class="formbutton btn btn-sm btn-info" value="Show" onClick="show_list_view ( 
                                        JSON.stringify({
                                        category_id: document.getElementById('cbo_item_category').value,
                                        product_id: document.getElementById('cbo_product').value,
                                        item_code: document.getElementById('txt_item_code').value,
                                        item_origin: document.getElementById('txt_origin').value,
                                        generic_id: document.getElementById('cbo_generic_name').value,
                                        reorder_level: document.getElementById('txt_reorder_level').value,
                                        'supplier_id': '{{$supplier_id}}',
                                    }), 'order/issue_product_search_list_view', 'search_div', '', 'setFilterGrid(\'tbl_po_list\',-1)')" style="width:70px;" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div id="search_div"></div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>

    function check_uncheck()
    {
        var checkBox = document.getElementById("txt_reorder_level");
        //if already checked then uncheck and set value to 0
        if (checkBox.checked == true){
            checkBox.value = 1;
        } else {
            checkBox.value = 0;
        }
    }
   
    var param_arr = [];
    function js_set_value(param )
    {
        // Parse the param JSON string to get the object
        var paramObj = JSON.parse(param);
        toggle( document.getElementById( 'tr_' + paramObj.product_id ), '#FFFFCC' );
       
        // Find if this product is already in the array
        var existingIndex = param_arr.findIndex(item => item.product_id === paramObj.product_id);
        
        if (existingIndex >= 0) {
            // Remove if exists
            param_arr.splice(existingIndex, 1);
        } else {
            // Add if doesn't exist
            param_arr.push(paramObj);
        }
        
        $('#popup_value').val(JSON.stringify(param_arr));
    }

    async function handleCategoryChange() {
        try {
            await load_drop_down_v2('load_drop_down',JSON.stringify({'category_id':document.getElementById('cbo_item_category').value,'onchange':'','class':'form-control form-control-sm'}), 'product_under_category', 'product_div')
        } catch (error) {
            console.error('Error loading dropdown:', error);
        }
    }
    if(<?=$cbo_category_id?> >0)
    {
        handleCategoryChange();
    }
</script>
@endsection
