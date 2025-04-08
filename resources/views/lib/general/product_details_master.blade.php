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
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-text">
                        <div class="card p-4" style="background-color: rgb(241, 241, 241);">
                            <form name="mainform_1" id="mainform_1" autocomplete="off">
                                <div class="row">
                                    <div class="col-sm-3 col-md-3 col-lg-3 form-group">
                                        <div class="row">
                                            <a href="{{ url('/product_export') }}" class="btn btn-info">Download Format</a>
                                        </div>
                                    </div>
                                    <div class="col-sm-5 col-md-5 col-lg-5 form-group">
                                        <div class="row"></div>
                                    </div>
                                    <div class="col-sm-4 col-md-4 col-lg-4 form-group">
                                        <div class="row">
                                            <form action="{{ route('product_import') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center">
                                                @csrf
                                                <div class="d-flex">
                                                    <div>
                                                        <input type="file" name="file" required class="form-control me-2">
                                                    </div>
                                                    <div>
                                                        <button type="submit" class="btn btn-info">Import</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3 col-md-3 col-lg-3 form-group">
                                        <div class="row">
                                            <label for="cbo_company_name" class="col-sm-6 col-form-label fw-bold text-start must_entry_caption">Company Name</label>
                                            <div class="col-sm-6 d-flex align-items-center">
                                                <select style="width: 100%" name="cbo_company_name" id="cbo_company_name" class="form-control">
                                                    <option value="0">SELECT</option>
                                                    <?php $lib_company = App\Models\Company::pluck('company_name', 'id'); ?>
                                                    @foreach($lib_company as $id => $company_name)
                                                    <option value="{{ $id }}">{{ $company_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-md-3 col-lg-3 form-group">
                                        <div class="row">
                                            <label for="cbo_supplier_name" class="col-sm-6 col-form-label fw-bold text-start must_entry_caption">Supplier</label>
                                            <div class="col-sm-6 d-flex align-items-center">
                                                <select style="width: 100%" name="cbo_supplier_name" id="cbo_supplier_name" class="form-control">
                                                <option value="0">SELECT</option>
                                                <?php
                                                    $lib_supplier = App\Models\LibSupplier::pluck('supplier_name', 'id');
                                                ?>
                                                @foreach($lib_supplier as $id => $supplier_name)
                                                    <option value="{{ $id }}">{{ $supplier_name }}</option>
                                                @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="col-sm-3 col-md-3 col-lg-3 form-group">
                                        <div class="row">
                                            <label for="cbo_generic_name" class="col-sm-6 col-form-label fw-bold text-start">Generic Name</label>
                                            <div class="col-sm-6 d-flex align-items-center">
                                                <select style="width: 100%" name="cbo_generic_name" id="cbo_generic_name" class="form-control">
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
                                    </div>
                                    <div class="col-sm-3 col-md-3 col-lg-3 form-group">
                                        <div class="row">
                                            <label for="cbo_item_category_name" class="col-sm-6 col-form-label fw-bold text-start must_entry_caption">Item Category</label>
                                            <div class="col-sm-6 d-flex align-items-center">
                                                <select style="width: 100%" name="cbo_item_category_name" id="cbo_item_category_name" onchange="handleCategoryChange()" class="form-control">
                                                    <option value="0">SELECT</option>
                                                    <?php
                                                        $lib_category = App\Models\LibCategory::pluck('category_name', 'id');
                                                    ?>
                                                    @foreach($lib_category as $id => $category_name)
                                                        <option value="{{ $id }}">{{ $category_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-md-3 col-lg-3 form-group">
                                        <div class="row">
                                            <label for="cbo_sub_category_name" class="col-sm-6 col-form-label fw-bold text-start must_entry_caption">Sub-Category</label>
                                            <div class="col-sm-6 d-flex align-items-center" id="sub_category_div">
                                                <select style="width: 100%" name="cbo_sub_category_name" id="cbo_sub_category_name" onchange="handleCategoryChange()" class="form-control">
                                                    <option value="0">SELECT</option>
                                                    <?php
                                                        $lib_sub_category = App\Models\LibItemSubCategory::pluck('sub_category_name', 'id');
                                                    ?>
                                                    @foreach($lib_sub_category as $id => $sub_category_name)
                                                        <option value="{{ $id }}">{{ $sub_category_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-md-3 col-lg-3 form-group">
                                        <div class="row">
                                            <label for="txt_item_type" class="col-sm-6 col-form-label fw-bold text-start">Type</label>
                                            <div class="col-sm-6 d-flex align-items-center">
                                                <input type="text" id="txt_item_type" class="form-control" name="txt_item_type">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-md-3 col-lg-3 form-group">
                                        <div class="row">
                                            <label for="txt_item_name" class="col-sm-6 col-form-label fw-bold text-start must_entry_caption">Item Name</label>
                                            <div class="col-sm-6 d-flex align-items-center">
                                                <input type="text" id="txt_item_name" class="form-control" name="txt_item_name">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-md-3 col-lg-3 form-group">
                                        <div class="row">
                                            <label for="txt_item_code" class="col-sm-6 col-form-label fw-bold text-start">Item Code</label>
                                            <div class="col-sm-6 d-flex align-items-center">
                                                <input type="text" id="txt_item_code" class="form-control" name="txt_item_code">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-md-3 col-lg-3 form-group">
                                        <div class="row">
                                            <label for="txt_item_origin" class="col-sm-6 col-form-label fw-bold text-start">Item Origin</label>
                                            <div class="col-sm-6 d-flex align-items-center">
                                                <input type="text" id="txt_item_origin" class="form-control" name="txt_item_origin">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-md-3 col-lg-3 form-group">
                                        <div class="row">
                                            <label for="cbo_brand_name" class="col-sm-6 col-form-label fw-bold text-start">Brand</label>
                                            <div class="col-sm-6 d-flex align-items-center">
                                                <select style="width: 100%" name="cbo_brand_name" id="cbo_brand_name" class="form-control">
                                                    <option value="0">SELECT</option>
                                                    <?php
                                                        $lib_brand = App\Models\LibBrand::pluck('brand_name', 'id');
                                                    ?>
                                                    @foreach($lib_brand as $id => $brand_name)
                                                        <option value="{{ $id }}">{{ $brand_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-md-3 col-lg-3 form-group">
                                        <div class="row">
                                            <label for="txt_dosage_form" class="col-sm-6 col-form-label fw-bold text-start">Dosage Form</label>
                                            <div class="col-sm-6 d-flex align-items-center">
                                                <input type="text" id="txt_dosage_form" class="form-control" name="txt_dosage_form">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-md-3 col-lg-3 form-group">
                                        <div class="row">
                                            <label for="cbo_color_name" class="col-sm-6 col-form-label fw-bold text-start">Color</label>
                                            <div class="col-sm-6 d-flex align-items-center">
                                                <select style="width: 100%" name="cbo_color_name" id="cbo_color_name" class="form-control">
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
                                    </div>
                                    <div class="col-sm-3 col-md-3 col-lg-3 form-group">
                                        <div class="row">
                                            <label for="cbo_order_uom" class="col-sm-6 col-form-label fw-bold text-start">Order UOM</label>
                                            <div class="col-sm-6 d-flex align-items-center">
                                                <select style="width: 100%" name="cbo_order_uom" id="cbo_order_uom" class="form-control">
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
                                    </div>
                                    <div class="col-sm-3 col-md-3 col-lg-3 form-group">
                                        <div class="row">
                                            <label for="cbo_consuption_uom" class="col-sm-6 col-form-label fw-bold text-start">Consuption UOM</label>
                                            <div class="col-sm-6 d-flex align-items-center">
                                                <select style="width: 100%" name="cbo_consuption_uom" id="cbo_consuption_uom" class="form-control">
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
                                    </div>
                                    <div class="col-sm-3 col-md-3 col-lg-3 form-group">
                                        <div class="row">
                                            <label for="txt_consuption_uom_qty" class="col-sm-6 col-form-label fw-bold text-start">Re Order Level</label>
                                            <div class="col-sm-6 d-flex align-items-center">
                                                <input type="text" id="txt_consuption_uom_qty" class="form-control" name="txt_consuption_uom_qty">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-md-3 col-lg-3 form-group">
                                        <div class="row">
                                            <label for="txt_conversion_fac" class="col-sm-6 col-form-label fw-bold text-start">Conversion fac.</label>
                                            <div class="col-sm-6 d-flex align-items-center">
                                                <input type="text" id="txt_conversion_fac" class="form-control" name="txt_conversion_fac">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-md-3 col-lg-3 form-group">
                                        <div class="row">
                                            <label for="cbo_size_name" class="col-sm-6 col-form-label fw-bold text-start">Item Size</label>
                                            <div class="col-sm-6 d-flex align-items-center">
                                                <select style="width: 100%" name="cbo_size_name" id="cbo_size_name" class="form-control" onchange="load_company_config(this.value)">
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
                                    </div>
                                    <div class="col-sm-3 col-md-3 col-lg-3 form-group">
                                        <div class="row">
                                            <label for="txt_power" class="col-sm-6 col-form-label fw-bold text-start">Power</label>
                                            <div class="col-sm-6 d-flex align-items-center">
                                                <input type="text" id="txt_power" class="form-control" name="txt_power">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-md-3 col-lg-3 form-group">
                                        <div class="row">
                                            <label for="cbo_group_name" class="col-sm-6 col-form-label fw-bold text-start">Item Group</label>
                                            <div class="col-sm-6 d-flex align-items-center">
                                                <select style="width: 100%" name="cbo_group_name" id="cbo_group_name" class="form-control" onchange="handleSubGroupChange()">
                                                    <option value="0">SELECT</option>
                                                    <?php
                                                        $lib_group_name = App\Models\LibItemGroup::pluck('item_name', 'id');
                                                    ?>
                                                    @foreach($lib_group_name as $id => $lib_group_name)
                                                        <option value="{{ $id }}">{{ $lib_group_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-md-3 col-lg-3 form-group">
                                        <div class="row">
                                            <label for="cbo_sub_group_name" class="col-sm-6 col-form-label fw-bold text-start">Sub Group</label>
                                            <div class="col-sm-6 d-flex align-items-center" id="sub_group_div">
                                                <select style="width: 100%" name="cbo_sub_group_name" id="cbo_sub_group_name" class="form-control" onchange="handleSubGroupChange()">
                                                    <option value="0">SELECT</option>
                                                    <?php 
                                                        $lib_sub_group_name = App\Models\LibItemSubGroup::pluck('sub_group_name', 'id');
                                                    ?>
                                                    @foreach($lib_sub_group_name as $id => $lib_sub_group_name)
                                                        <option value="{{ $id }}">{{ $lib_sub_group_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div> 
                                </div>

                                <div class="row">
                                    <div class="mb-3 row d-flex justify-content-center mt-2">
                                        <div class="col-sm-2">
                                        </div>
                                        <div class="col-sm-6">
                                            <?php  echo load_submit_buttons( $permission, "fnc_item_creation", 0,0 ,"reset_form('mainform_1','','',1)"); ?>
                                            <input type="hidden" name="update_id" id="update_id">
                                        </div>
                                       
                                    </div>
                                </div>

                               <div class="row" id="div_dtls_list_view">
                                    <table class="table table-bordered table-striped text-center" id="dtls_list_view">
                                        <thead>
                                            <tr>
                                                <th width="3%">Sl</th>
                                                <th width="12%">Generic Name</th>
                                                <th width="15%">Item Name</th>
                                                <th width="10%">Item Code</th>
                                                <th width="12%">Item Category</th>
                                                <th width="13%">Brand</th>
                                                <th width="8%">Item Color</th>
                                                <th width="8%">Conversion fac.</th>
                                                <th width="8%">Type</th>
                                                <th>Dosage Form</th>
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
                                                            ->select('a.id','a.item_description','a.item_code','a.conversion_fac','a.item_type','a.dosage_form','b.generic_name','c.category_name','d.brand_name','e.color_name')
                                                            ->where('a.deleted_at',null)
                                                            ->get();
                                            ?>
                                            @foreach($lib_items as $lib_item)
                                            <tr id="tr_{{$sl}}" onclick="load_php_data_to_form('{{$lib_item->id}}')" style="cursor:pointer">
                                                <td>{{$sl++}}</td>
                                                <td>{{$lib_item->generic_name}}</td>
                                                <td>{{$lib_item->item_description}}</td>
                                                <td>{{$lib_item->item_code}}</td>
                                                <td>{{$lib_item->category_name}}</td>
                                                <td>{{$lib_item->brand_name}}</td>
                                                <td>{{$lib_item->color_name}}</td>
                                                <td>{{$lib_item->conversion_fac}}</td>
                                                <td>{{$lib_item->item_type}}</td>
                                                <td>{{$lib_item->dosage_form}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
     var permission ='{{$permission}}';
     var setup_data = load_all_setup(13); // Pass the entry_form dynamically
    // console.log(setup_data);

    function fnc_item_creation( operation )
    {
        if (form_validation('cbo_company_name*cbo_supplier_name*cbo_item_category_name*txt_item_name','Company Name*Supplier Name*Item Category*Item Name')==false)
        {
            return;
        }
        else
        {
        
            var formData = get_form_data('cbo_company_name,cbo_supplier_name,cbo_generic_name,cbo_item_category_name,cbo_sub_category_name,txt_item_type,txt_item_name,txt_item_code,txt_item_origin,cbo_brand_name,txt_dosage_form,cbo_color_name,cbo_order_uom,cbo_consuption_uom,txt_consuption_uom_qty,txt_conversion_fac,cbo_size_name,txt_power,update_id,cbo_group_name,cbo_sub_group_name');
            //console.log(formData);
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
        var columns = 'company_id*supplier_id*generic_id*item_category_id*item_sub_category_id*item_type*item_description*item_code*item_origin*brand_id*dosage_form*color_id*order_uom*consuption_uom*consuption_uom_qty*conversion_fac*size_id*power*id*item_group_id*item_sub_group_id';

        var response = await populate_field_data('id', menuId, 'product_details_master', columns, '{{csrf_token()}}', '');
        
        if (response.code === 18 && response.data) {
            var data = response.data;
            //console.table(data);
            $('#cbo_company_name').val(data.company_id);
            $('#cbo_supplier_name').val(data.supplier_id);
            $('#cbo_generic_name').val(data.generic_id);
            $('#cbo_item_category_name').val(data.item_category_id);
            await handleCategoryChange(); // Await the company change
            $('#cbo_sub_category_name').val(data.item_sub_category_id).trigger('change');
            $('#txt_item_type').val(data.item_type);
            $('#txt_item_name').val(data.item_description);
            $('#txt_item_code').val(data.item_code);
            $('#txt_item_origin').val(data.item_origin);
            $('#cbo_brand_name').val(data.brand_id);
            $('#txt_dosage_form').val(data.dosage_form);
            $('#cbo_color_name').val(data.color_id);
            $('#cbo_order_uom').val(data.order_uom);
            $('#cbo_consuption_uom').val(data.consuption_uom);
            $('#txt_consuption_uom_qty').val(data.consuption_uom_qty);
            $('#txt_conversion_fac').val(data.conversion_fac);
            $('#cbo_size_name').val(data.size_id);
            $('#txt_power').val(data.power);
            $('#cbo_group_name').val(data.item_group_id);
            await handleSubGroupChange(); // Await the company change
            $('#cbo_sub_group_name').val(data.item_sub_group_id).trigger('change');
            document.getElementById('update_id').value = data.id;
            set_button_status(1, permission, 'fnc_item_creation',1);
        } else {
            console.warn("Unexpected data format:", response);
        }
        release_freezing();
    }


    async function handleCategoryChange() {
        try {
            await load_drop_down_v2('load_drop_down',JSON.stringify({'category_id':document.getElementById('cbo_item_category_name').value,'onchange':''}), 'sub_category_under_category', 'sub_category_div');

        } catch (error) {
            console.error('Error loading dropdown:', error);
        }
    }
    
    async function handleSubGroupChange() {
        try {
            await load_drop_down_v2('load_drop_down',JSON.stringify({'group_id':document.getElementById('cbo_group_name').value,'onchange':''}), 'sub_group_under_group', 'sub_group_div');

        } catch (error) {
            console.error('Error loading dropdown:', error);
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
