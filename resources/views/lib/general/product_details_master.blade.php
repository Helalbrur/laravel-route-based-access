<?php
//dd(session('laravel_stater.data_arr.8'));
$permission = getPagePermission(request('mid') ?? 0);
$title = getMenuName(request('mid') ?? 0) ?? 'Item Creation';
?>
@extends('layouts.app')
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
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
                    <h4 class="card-title">{{getMenuName(request('mid') ?? 0) ?? 'Item Creation'}}</h4>
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
                                <label for="cbo_company_name"  class="col-sm-2 col-form-label">Generic Name</label>
                                <div class="col-sm-4 col-lg-2">
                                    <select name="cbo_company_name" id="cbo_company_name" onchange="load_company_config(this.value)" class="form-control">
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
                                <label for="cbo_company_name"  class="col-sm-2 col-form-label must_entry_caption">Item Category</label>
                                <div class="col-sm-4 col-lg-2">
                                    <select name="cbo_company_name" id="cbo_company_name" onchange="load_company_config(this.value)" class="form-control">
                                        <option value="0">SELECT</option>
                                        <?php
                                            $lib_category = App\Models\LibCategory::pluck('category_name', 'id');
                                        ?>
                                        @foreach($lib_category as $id => $category_name)
                                            <option value="{{ $id }}">{{ $category_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <label for="cbo_company_name"  class="col-sm-2 col-form-label">Item Sub-Category</label>
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
                                <label for="txt_location_name" class="col-sm-2 col-form-label">Type</label>
                                <div class="col-sm-4 col-lg-2">
                                    <input type="text" id="txt_location_name" class="form-control" name="txt_location_name">
                                </div>
                            </div>
                            <div class="form-group row"> 
                                <label for="txt_location_name" class="col-sm-2 col-form-label">Item Name</label>
                                <div class="col-sm-4 col-lg-2">
                                    <input type="text" id="txt_location_name" class="form-control" name="txt_location_name">
                                </div>

                                <label for="txt_location_name" class="col-sm-2 col-form-label">Item Code</label>
                                <div class="col-sm-4 col-lg-2">
                                    <input type="text" id="txt_location_name" class="form-control" name="txt_location_name">
                                </div>
                                <label for="txt_location_name" class="col-sm-2 col-form-label">Item Origin</label>
                                <div class="col-sm-4 col-lg-2">
                                    <input type="text" id="txt_location_name" class="form-control" name="txt_location_name">
                                </div>
                            </div>

                            <div class="form-group row"> 
                                <label for="txt_location_name" class="col-sm-2 col-form-label">Brand</label>
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

                                <label for="txt_location_name" class="col-sm-2 col-form-label">Dosage Form</label>
                                <div class="col-sm-4 col-lg-2">
                                    <input type="text" id="txt_location_name" class="form-control" name="txt_location_name">
                                </div>

                                <label for="txt_location_name" class="col-sm-2 col-form-label">Item Color</label>
                                <div class="col-sm-4 col-lg-2">
                                    <input type="text" id="txt_location_name" class="form-control" name="txt_location_name">
                                </div>
                            </div>

                            <div class="form-group row"> 
                                <label for="txt_location_name" class="col-sm-2 col-form-label">Order UOM</label>
                                <div class="col-sm-4 col-lg-2">
                                    <select name="cbo_company_name" id="cbo_company_name" onchange="load_company_config(this.value)" class="form-control">
                                        <option value="0">SELECT</option>
                                        <?php
                                            $lib_uom = App\Models\LibUom::pluck('uom_name', 'id');
                                        ?>
                                        @foreach($lib_uom as $id => $uom_name)
                                            <option value="{{ $id }}">{{ $uom_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <label for="txt_location_name" class="col-sm-2 col-form-label">Order UOM Qty</label>
                                <div class="col-sm-4 col-lg-2">
                                    <input type="text" id="txt_location_name" class="form-control" name="txt_location_name">
                                </div>

                                <label for="txt_location_name" class="col-sm-2 col-form-label">Consuption UOM</label>
                                <div class="col-sm-4 col-lg-2">
                                    <select name="cbo_company_name" id="cbo_company_name" onchange="load_company_config(this.value)" class="form-control">
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
                                <label for="txt_location_name" class="col-sm-2 col-form-label">Consuption UOM Qty</label>
                                <div class="col-sm-4 col-lg-2">
                                    <input type="text" id="txt_location_name" class="form-control" name="txt_location_name">
                                </div>

                                <label for="txt_location_name" class="col-sm-2 col-form-label">Conversion fac.</label>
                                <div class="col-sm-4 col-lg-2">
                                    <input type="text" id="txt_location_name" class="form-control" name="txt_location_name">
                                </div> 

                                <label for="txt_location_name" class="col-sm-2 col-form-label">Item Size</label>
                                <div class="col-sm-4 col-lg-2">
                                    <input type="text" id="txt_location_name" class="form-control" name="txt_location_name">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="txt_location_name" class="col-sm-2 col-form-label">Power</label>
                                <div class="col-sm-4 col-lg-2">
                                    <input type="text" id="txt_location_name" class="form-control" name="txt_location_name">
                                </div>
                            </div>
                            <div class="from-group row">
                                <div class="col-sm-2">
                                    <input type="hidden" name="update_id" id="update_id">
                                </div>
                                <div class="col-sm-7">
                                    <?php
                                        echo load_submit_buttons( $permission, "fnc_company_name", 0,0 ,"reset_form('mainform_1','','',1)");
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
                                    $sl = 1;
                                    $locations = App\Models\ProductDetailsMaster::get();
                                
                                ?>
                                @foreach($locations as $location)
                                <tr id="tr_{{$sl}}" onclick="load_php_data_to_form('{{$location->id}}')" style="cursor:pointer">
                                    <td>{{$sl++}}</td>
                                    <td>{{$location->location_name}}</td>
                                    <td>{{$location->company->company_name ?? ''}}</td>
                                    <td>{{$location->country->country_name ?? ''}}</td>
                                    <td>{{$location->email}}</td>
                                    <td>{{$location->website}}</td>
                                    <td>{{$location->contact_no}}</td>
                                    <td>{{$location->address}}</td>
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
     var field_level_data = "";
     @if(session()->has('laravel_stater.data_arr.8'))
        @php
            $dataArr = json_encode(session('laravel_stater.data_arr.8'));
            echo "field_level_data = ".$dataArr.";\n";
        @endphp
    @endif
    function fnc_company_name( operation )
    {
        if (form_validation('cbo_company_name*txt_location_name',' Company Name*Location Name')==false)
        {
            return;
        }
        else
        {
            var mandatoryField = "";
            var mandatoryMessage = "";
            @if(session()->has('laravel_stater.mandatory_field.8'))
                mandatoryField = '<?php echo implode('*', session('laravel_stater.mandatory_field.8')); ?>';
                mandatoryMessage = '<?php echo implode('*', session('laravel_stater.mandatory_message.8')); ?>';
            @endif

            // Check if mandatoryField is not empty
            if (mandatoryField)
            {
                // Call the form_validation function passing mandatoryField and mandatoryMessage
                if (form_validation(mandatoryField, mandatoryMessage) == false)
                {
                    return;
                }
            }
            var formData = get_form_data('cbo_company_name,txt_location_name,cbo_country_name,txt_email,txt_website_name,txt_contact_no,txt_contact_person,txt_company_address,update_id');
            var method ="POST";
            var param = "";
            if(operation == 1 || operation == 2)
            {
                param = `/${document.getElementById('update_id').value}`;
                if(operation == 1) formData.append('_method', 'PUT');
                else formData.append('_method', 'DELETE');
            }
            formData.append('_token', '{{csrf_token()}}');
            var url = `/lib/location${param}`;
            var requestData = {
                method: method,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                body: formData
            };

            save_update_delete(operation,url,requestData,'id','show_location_list_view','list_view_div','mainform_1');
        }
    }

    const load_php_data_to_form =async (menuId) =>
    {
        var columns = 'location_name*company_id*country_id*contact_person*contact_no*website*email*address*id';
        var fields = 'txt_location_name*cbo_company_name*cbo_country_name*txt_contact_person*txt_contact_no*txt_website_name*txt_email*txt_company_address*update_id';
        var others = '';
       var get_return_value = await populate_form_data('id',menuId,'lib_location',columns,fields,'{{csrf_token()}}');
       if(get_return_value == 1)
       {
         set_button_status(1, permission, 'fnc_company_name',1);
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
