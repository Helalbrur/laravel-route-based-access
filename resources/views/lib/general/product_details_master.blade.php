<?php
//dd(session('laravel_stater.data_arr.8'));
$permission = getPagePermission(request('mid') ?? 0);
$title = getMenuName(request('mid') ?? 0) ?? 'Item Creation';
?>
@extends('layouts.app')
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-12 d-flex justify-content-center">
            <h1 class="m-0 align-center"><strong>{{getMenuName(request('mid') ?? 0) ?? 'Item Creation'}}</strong></h1>
        </div>
        
    </div><!-- /.row -->
@endsection()
@section('content')
<div class="row">
    <div class="col-lg-12">
        <center>
            <div class="card">
                <div class="card-body" style="justify-content:center;">
                    <div class="card-text">
                        <form name="mainform_1" id="mainform_1" autocomplete="off">
                        <div class="form-group row">
                                <label for="cbo_company_name" class="col-sm-2 col-form-label must_entry_caption">Company</label>
                                <div class="col-sm-4 col-lg-2">
                                    <select name="cbo_company_name" id="cbo_company_name" onchange="load_company_config(this.value)" class="form-control">
                                        <option value="0">SELECT</option>
                                        <?php
                                            $lib_company = App\Models\Company::pluck('company_name', 'id');
                                        ?>
                                        @foreach($lib_company as $id => $company_name)
                                            <option value="{{ $id }}">{{ $company_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <label for="cbo_supplier_name"  class="col-sm-2 col-form-label must_entry_caption">Supplier</label>
                                <div class="col-sm-4 col-lg-2">
                                    <select name="cbo_supplier_name" id="cbo_supplier_name" onchange="load_company_config(this.value)" class="form-control">
                                        <option value="0">SELECT</option>
                                        <?php
                                            $lib_supplier = App\Models\LibSupplier::pluck('supplier_name', 'id');
                                        ?>
                                        @foreach($lib_supplier as $id => $supplier_name)
                                            <option value="{{ $id }}">{{ $supplier_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <label for="cbo_generic_name"  class="col-sm-2 col-form-label">Generic Name</label>
                                <div class="col-sm-4 col-lg-2">
                                    <select name="cbo_generic_name" id="cbo_generic_name" onchange="load_company_config(this.value)" class="form-control">
                                        <option value="0">SELECT</option>
                                        <?php
                                            $lib_generic = App\Models\LibGeneric::pluck('generic_name', 'id');
                                        ?>
                                        @foreach($lib_generic as $id => $generic_name)
                                            <option value="{{ $id }}">{{ $generic_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="cbo_item_category_name"  class="col-sm-2 col-form-label must_entry_caption">Item Category</label>
                                <div class="col-sm-4 col-lg-2">
                                    <select name="cbo_item_category_name" id="cbo_item_category_name" onchange="load_company_config(this.value)" class="form-control">
                                        <option value="0">SELECT</option>
                                        <?php
                                            $lib_category = App\Models\LibCategory::pluck('category_name', 'id');
                                        ?>
                                        @foreach($lib_category as $id => $category_name)
                                            <option value="{{ $id }}">{{ $category_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <label for="cbo_sub_category_name"  class="col-sm-2 col-form-label">Item Sub-Category</label>
                                <div class="col-sm-4 col-lg-2">
                                    <select name="cbo_sub_category_name" id="cbo_sub_category_name" onchange="load_company_config(this.value)" class="form-control">
                                        <option value="0">SELECT</option>
                                        <?php
                                            $lib_sub_category = App\Models\LibItemSubCategory::pluck('sub_category_name', 'id');
                                        ?>
                                        @foreach($lib_sub_category as $id => $sub_category_name)
                                            <option value="{{ $id }}">{{ $sub_category_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <label for="txt_item_type" class="col-sm-2 col-form-label">Type</label>
                                <div class="col-sm-4 col-lg-2">
                                    <input type="text" id="txt_item_type" class="form-control" name="txt_item_type">
                                </div>
                            </div>
                            <div class="form-group row"> 
                                <label for="txt_item_name" class="col-sm-2 col-form-label must_entry_caption">Item Name</label>
                                <div class="col-sm-4 col-lg-2">
                                    <input type="text" id="txt_item_name" class="form-control" name="txt_item_name">
                                </div>

                                <label for="txt_item_code" class="col-sm-2 col-form-label">Item Code</label>
                                <div class="col-sm-4 col-lg-2">
                                    <input type="text" id="txt_item_code" class="form-control" name="txt_item_code">
                                </div>
                                <label for="txt_item_origin" class="col-sm-2 col-form-label">Item Origin</label>
                                <div class="col-sm-4 col-lg-2">
                                    <input type="text" id="txt_item_origin" class="form-control" name="txt_item_origin">
                                </div>
                            </div>

                            <div class="form-group row"> 
                                <label for="cbo_brand_name" class="col-sm-2 col-form-label">Brand</label>
                                <div class="col-sm-4 col-lg-2">
                                    <select name="cbo_brand_name" id="cbo_brand_name" onchange="load_company_config(this.value)" class="form-control">
                                        <option value="0">SELECT</option>
                                        <?php
                                            $lib_brand = App\Models\LibBrand::pluck('name', 'id');
                                        ?>
                                        @foreach($lib_brand as $id => $name)
                                            <option value="{{ $id }}">{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <label for="txt_dosage_form" class="col-sm-2 col-form-label">Dosage Form</label>
                                <div class="col-sm-4 col-lg-2">
                                    <input type="text" id="txt_dosage_form" class="form-control" name="txt_dosage_form">
                                </div>

                                <label for="cbo_color_name" class="col-sm-2 col-form-label">Color</label>
                                <div class="col-sm-4 col-lg-2">
                                    <select name="cbo_color_name" id="cbo_color_name" onchange="load_company_config(this.value)" class="form-control">
                                        <option value="0">SELECT</option>
                                        <?php
                                            $lib_color = App\Models\LibColor::pluck('color_name', 'id');
                                        ?>
                                        @foreach($lib_color as $id => $color_name)
                                            <option value="{{ $id }}">{{ $color_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row"> 
                                <label for="cbo_order_uom" class="col-sm-2 col-form-label">Order UOM</label>
                                <div class="col-sm-4 col-lg-2">
                                    <select name="cbo_order_uom" id="cbo_order_uom" onchange="load_company_config(this.value)" class="form-control">
                                        <option value="0">SELECT</option>
                                        <?php
                                            $lib_uom = App\Models\LibUom::pluck('uom_name', 'id');
                                        ?>
                                        @foreach($lib_uom as $id => $uom_name)
                                            <option value="{{ $id }}">{{ $uom_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <label for="txt_order_uom_qty" class="col-sm-2 col-form-label">Order UOM Qty</label>
                                <div class="col-sm-4 col-lg-2">
                                    <input type="text" id="txt_order_uom_qty" class="form-control" name="txt_order_uom_qty">
                                </div>

                                <label for="cbo_consuption_uom" class="col-sm-2 col-form-label">Consuption UOM</label>
                                <div class="col-sm-4 col-lg-2">
                                    <select name="cbo_consuption_uom" id="cbo_consuption_uom" onchange="load_company_config(this.value)" class="form-control">
                                        <option value="0">SELECT</option>
                                        <?php
                                            $lib_uom = App\Models\LibUom::pluck('uom_name', 'id');
                                        ?>
                                        @foreach($lib_uom as $id => $uom_name)
                                            <option value="{{ $id }}">{{ $uom_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="txt_consuption_uom_qty" class="col-sm-2 col-form-label">Consuption UOM Qty</label>
                                <div class="col-sm-4 col-lg-2">
                                    <input type="text" id="txt_consuption_uom_qty" class="form-control" name="txt_consuption_uom_qty">
                                </div>

                                <label for="txt_conversion_fac" class="col-sm-2 col-form-label">Conversion fac.</label>
                                <div class="col-sm-4 col-lg-2">
                                    <input type="text" id="txt_conversion_fac" class="form-control" name="txt_conversion_fac">
                                </div> 

                                <label for="cbo_size_name" class="col-sm-2 col-form-label">Item Size</label>
                                <div class="col-sm-4 col-lg-2">
                                    <select name="cbo_size_name" id="cbo_size_name" onchange="load_company_config(this.value)" class="form-control">
                                        <option value="0">SELECT</option>
                                        <?php
                                            $lib_size = App\Models\LibSize::pluck('size_name', 'id');
                                        ?>
                                        @foreach($lib_size as $id => $size_name)
                                            <option value="{{ $id }}">{{ $size_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="txt_power" class="col-sm-2 col-form-label">Power</label>
                                <div class="col-sm-4 col-lg-2">
                                    <input type="text" id="txt_power" class="form-control" name="txt_power">
                                </div>
                            </div>
                            <div class="from-group row">
                                <div class="col-sm-2">
                                    <input type="hidden" name="update_id" id="update_id">
                                </div>
                                <div class="col-sm-7">
                                    <?php
                                        echo load_submit_buttons( $permission, "fnc_item_creation", 0,0 ,"reset_form('mainform_1','','',1)");
                                    ?>
                                </div>
                                
                            </div>
                        </form>
                    </div>

                    <div class="card table-responsive table-info"  id="list_view_div" style="background-color:#F5FFFA">
                        <table class="table table-bordered table-striped" >
                            <thead>
                                <tr>
                                    <th width="3%">Sl</th>
                                    <th width="12%">Generic Name</th>
                                    <th width="15%">Item Name</th>
                                    <th width="10%">Item Code</th>
                                    <th width="12%">Item Category</th>
                                    <th width="13%">Brand</th>
                                    <th width="13%">Item Color</th>
                                    <th>Conversion fac.</th>
                                </tr>
                            </thead>
                            <tbody id="list_view">
                                <?php
                                    use Illuminate\Support\Facades\DB;
                                    $sl = 1;

                                    $lib_items = DB::table('product_details_master as a')
                                                ->leftJoin('lib_generic as b','a.generic_id','=','b.id')
                                                ->leftJoin('lib_category as c','a.item_category_id','=','c.id')
                                                ->leftJoin('lib_brand as d','a.brand_id','=','d.id')
                                                ->leftJoin('lib_color as e','a.color_id','=','e.id')
                                                ->select('a.id','a.item_description','a.item_code','a.conversion_fac','b.generic_name','c.category_name','d.name','e.color_name')
                                                ->get();
                                ?>
                                @foreach($lib_items as $lib_item)
                                <tr id="tr_{{$sl}}" onclick="load_php_data_to_form('{{$lib_item->id}}')" style="cursor:pointer">
                                    <td>{{$sl++}}</td>
                                    <td>{{$lib_item->generic_name}}</td>
                                    <td>{{$lib_item->item_description}}</td>
                                    <td>{{$lib_item->item_code}}</td>
                                    <td>{{$lib_item->category_name}}</td>
                                    <td>{{$lib_item->name}}</td>
                                    <td>{{$lib_item->color_name}}</td>
                                    <td>{{$lib_item->conversion_fac}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </center>
    </div>
</div>

@endsection

@section('script')
<script>
     var permission ='{{$permission}}';

    function fnc_item_creation( operation )
    {
        if (form_validation('cbo_company_name*cbo_supplier_name*cbo_item_category_name*txt_item_name','Company Name*Supplier Name*Item Category*Item Name')==false)
        {
            return;
        }
        else
        {
        
            var formData = get_form_data('cbo_company_name,cbo_supplier_name,cbo_generic_name,cbo_item_category_name,cbo_sub_category_name,txt_item_type,txt_item_name,txt_item_code,txt_item_origin,cbo_brand_name,txt_dosage_form,cbo_color_name,cbo_order_uom,txt_order_uom_qty,cbo_consuption_uom,txt_consuption_uom_qty,txt_conversion_fac,cbo_size_name,txt_power,update_id');
            var method ="POST";
            var param = "";
            if(operation == 1 || operation == 2)
            {
                param = `/${document.getElementById('update_id').value}`;
                if(operation == 1) formData.append('_method', 'PUT');
                else formData.append('_method', 'DELETE');
            }
            formData.append('_token', '{{csrf_token()}}');
            var url = `/lib/general/product_details_master${param}`;
            var requestData = {
                method: method,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                body: formData
            };

            save_update_delete(operation,url,requestData,'id','show_product_details_master_list_view','list_view_div','mainform_1');
        }
    }

    const load_php_data_to_form =async (menuId) =>
    {
        var columns = 'company_id*supplier_id*generic_id*item_category_id*item_sub_category_id*item_type*item_description*item_code*item_origin*brand_id*dosage_form*color_id*order_uom*order_uom_qty*consuption_uom*consuption_uom_qty*conversion_fac*size_id*power*id';
        var fields = 'cbo_company_name*cbo_supplier_name*cbo_generic_name*cbo_item_category_name*cbo_sub_category_name*txt_item_type*txt_item_name*txt_item_code*txt_item_origin*cbo_brand_name*txt_dosage_form*cbo_color_name*cbo_order_uom*txt_order_uom_qty*cbo_consuption_uom*txt_consuption_uom_qty*txt_conversion_fac*cbo_size_name*txt_power*update_id';
        var others = '';
       var get_return_value = await populate_form_data('id',menuId,'product_details_master',columns,fields,'{{csrf_token()}}');
       if(get_return_value == 1)
       {
         set_button_status(1, permission, 'fnc_item_creation',1);
       }
    }

    make_mandatory(8);
    setFilterGrid("list_view",-1);
    function load_company_config(company)
    {
        set_field_level_access( company )
    }

</script>
@endsection
