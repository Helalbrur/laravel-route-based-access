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
                    <table id="list_view" class="table table-striped" style="width: 100%">
                        <thead>
                            <tr>
                                
                                <th>Item Category</th>
                                <th>Item Name</th>
                                <th>Item Code</th>
                                <th>

                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <select class="form-control" id="cbo_item_category" name="cbo_item_category" style="width: 100%" 
                                            onchange="handleCategoryChange()">
                                        <option value="">--All--</option>
                                        @foreach(get_item_category() as $category_id => $category_name)
                                            <option value="{{$category_id}}" {{ ($category_id == $cbo_category_id) ? 'selected' : '' }}>{{$category_name}}</option>
                                        @endforeach
                                    </select>
                                </td>

                                <td id="product_div">
                                    <select class="form-control" id="cbo_product" name="cbo_product" style="width: 100%">
                                        <option value="">--All--</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" class="form-control" id="txt_item_code" name="txt_item_code" value="{{$item_code}}" placeholder="Item Code">
                                </td>
                                <td>
                                    <input type="button" name="button2" class="formbutton btn btn-info" value="Show" onClick="show_list_view ( 
                                        JSON.stringify({
                                        category_id: document.getElementById('cbo_item_category').value,
                                        product_id: document.getElementById('cbo_product').value,
                                        item_code: document.getElementById('txt_item_code').value
                                    }), 'order/product_search_list_view', 'search_div', '', 'setFilterGrid(\'tbl_po_list\',-1)')" style="width:70px;" />
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

    var tableFilters ={col_2: "select",display_all_text: " --All--"}

    var selected_id = new Array;
    var selected_name = new Array;

    function check_all_data() {
        var tbl_row_count = document.getElementById( 'list_view' ).rows.length;
        tbl_row_count = tbl_row_count - 0;

        //This part is for range check -------start;
        var check_from=$('#txt_check_from').val();
        var check_to=$('#txt_check_to').val();
        if($('#check_all'). prop("checked") == true){
            $('#txt_check_from').attr("disabled", true);
            $('#txt_check_to').attr("disabled", true);
        }
        else
        {
            $('#txt_check_from').attr("disabled",false);
            $('#txt_check_to').attr("disabled", false);
        }
        check_from=(check_from)?check_from:1;
        check_to=(check_to)?check_to:tbl_row_count;
        //-------end;



        for( var i = check_from; i <= check_to; i++ ) {
            var onclickString = $('#tr_' + i).attr('onclick');
            var paramArr = onclickString.split("'");
            var functionParam = paramArr[1];


            if($('#tr_' + i).is(':visible'))
            {
                js_set_value( functionParam );
            }


        }
    }

    function toggle( x, origColor ) {
        var newColor = 'yellow';
        if ( x.style ) {
            x.style.backgroundColor = ( newColor == x.style.backgroundColor )? origColor : newColor;
        }
    }

    function js_set_value( strCon )
    {
        var splitSTR = strCon.split("_");
        var str = splitSTR[0];
        var selectID = splitSTR[1];
        var selectDESC = splitSTR[2];
        toggle( document.getElementById( 'tr_' + str ), '#FFFFCC' );

        if( jQuery.inArray( selectID, selected_id ) == -1 ) {
            selected_id.push( selectID );
            selected_name.push( selectDESC );
        }
        else {
            for( var i = 0; i < selected_id.length; i++ ) {
                if( selected_id[i] == selectID ) break;
            }
            selected_id.splice( i, 1 );
            selected_name.splice( i, 1 );
        }
        var id = ''; var name = ''; var job = '';
        for( var i = 0; i < selected_id.length; i++ ) {
            id += selected_id[i] + ',';
            name += selected_name[i] + ',';
        }
        id 		= id.substr( 0, id.length - 1 );
        name 	= name.substr( 0, name.length - 1 );

        $('#txt_selected_id').val( id );
        $('#txt_selected').val( name );
    }

    async function handleCategoryChange() {
        try {
            await load_drop_down_v2('load_drop_down',JSON.stringify({'category_id':document.getElementById('cbo_item_category').value,'onchange':''}), 'product_under_category', 'product_div')
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
