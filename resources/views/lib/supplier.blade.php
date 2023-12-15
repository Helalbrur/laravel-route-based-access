<?php
$permission = getPagePermission(request('mid') ?? 0);
$title = getMenuName(request('mid') ?? 0) ?? 'Color Entry';
?>
@extends('layouts.app')
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 align-center"><strong>{{getMenuName(request('mid') ?? 0) ?? 'Supplier Profile'}}</strong></h1>
        </div>
        
    </div><!-- /.row -->
@endsection()
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">

                
                <div class="card-text">
                    <form name="mainform_1" id="mainform_1" autocomplete="off">
                        
                        <div class="form-group row">
                           
                            <label for="txt_supplier_name" class="col-sm-2 col-form-label must_entry_caption">Supplier Name</label>
                            <div class="col-sm-4">
                                <input type="text" id="txt_supplier_name" class="form-control" name="txt_supplier_name">
                            </div>
                            <label for="txt_short_name" class="col-sm-2 col-form-label must_entry_caption">Short Name</label>
                            <div class="col-sm-4">
                                <input type="text" id="txt_short_name" class="form-control" name="txt_short_name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="cbo_country_name" class="col-sm-2 col-form-label">Country Name</label>
                            <div class="col-sm-4">
                                <select name="cbo_country_name" id="cbo_country_name" class="form-control">
                                    <option value="0">SELECT</option>
                                    <?php
                                        $lib_country = App\Models\LibCountry::pluck('country_name', 'id');
                                    ?>
                                    @foreach($lib_country as $id => $country_name)
                                        <option value="{{ $id }}">{{ $country_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label for="txt_email" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-4">
                                <input type="email" id="txt_email" class="form-control" name="txt_email">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="txt_website_name" class="col-sm-2 col-form-label">Website</label>
                            <div class="col-sm-4">
                                <input type="text" id="txt_website_name" class="form-control" name="txt_website_name">
                            </div>
                            <label for="txt_contact_no" class="col-sm-2 col-form-label">Contact No</label>
                            <div class="col-sm-4">
                                <input type="email" id="txt_contact_no" class="form-control" name="txt_contact_no">
                            </div>
                        </div>
                        <div class="form-group row">
                            
                            <label for="txt_contact_person" class="col-sm-2 col-form-label">Contact Person</label>
                            <div class="col-sm-4">
                                <input type="email" id="txt_contact_person" class="form-control" name="txt_contact_person">
                            </div>
                            <label for="txt_supplier_address" class="col-sm-2 col-form-label">Address</label>
                            <div class="col-sm-4">
                                <input type="text" id="txt_supplier_address" class="form-control" name="txt_supplier_address">
                            </div>
                        </div>
                        <div class="form-group row">
                            
                            <label for="cbo_tag_company_name"  class="col-sm-2 col-form-label">Tag Company Name</label>
                            <div class="col-sm-4">
                                <select name="cbo_tag_company_name" id="cbo_tag_company_name"  class="form-control">
                                    <option value="0">SELECT</option>
                                    <?php
                                        $lib_company = App\Models\Company::pluck('company_name', 'id');
                                    ?>
                                    @foreach($lib_company as $id => $company_name)
                                        <option value="{{ $id }}">{{ $company_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label for="cbo_tag_party_name"  class="col-sm-2 col-form-label">Tag Party Name</label>
                            <div class="col-sm-4">
                                <select name="cbo_tag_party_name" id="cbo_tag_party_name" class="form-control">
                                    
                                    <?php
                                        $party_types =party_type_supplier();
                                    ?>
                                    @foreach($party_types as $id => $party_name)
                                        <option value="{{ $id }}">{{ $party_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                       
                        <div class="from-group row">
                            <div class="col-sm-2">
                                <input type="hidden" name="update_id" id="update_id">
                            </div>
                            <div class="col-sm-7">
                                <?php
                                    echo load_submit_buttons( $permission, "fnc_supplier_name", 0,0 ,"reset_form('mainform_1','','',1)");
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
                                <th width="12%">Supplier Name</th>
                                <th width="15%">Company Name</th>
                                <th width="10%">Country Name</th>
                                <th width="12%">Email</th>
                                <th width="13%">Website</th>
                                <th width="13%">Contact No</th>
                                <th >Address</th>
                            </tr>
                        </thead>
                        <tbody id="list_view">
                            <?php
                                $sl = 1;
                                $suppliers = App\Models\LibSupplier::get();
                            
                            ?>
                            @foreach($suppliers as $supplier)
                                <tr id="tr_{{$sl}}" onclick="load_php_data_to_form('{{$supplier->id}}')" style="cursor:pointer">
                                    <td>{{$sl++}}</td>
                                    <td>{{$supplier->supplier_name}}</td>
                                    <td>
                                        <?php $i = 0;?>
                                        @foreach($supplier->company as $com)
                                            {{$com->company_name}}
                                            {{ $i > 0 ? ',' : '' }}
                                            <?php $i++;?>
                                        @endforeach
                                    </td>
                                    <td>{{$supplier->country->country_name ?? ''}}</td>
                                    <td>{{$supplier->email}}</td>
                                    <td>{{$supplier->website}}</td>
                                    <td>{{$supplier->contact_no}}</td>
                                    <td>{{$supplier->address}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
     var permission ='{{$permission}}';
     var field_level_data = "";
     @if(session()->has('laravel_stater.data_arr.10'))
        @php
            $dataArr = json_encode(session('laravel_stater.data_arr.10'));
            echo "field_level_data = ".$dataArr.";\n";
        @endphp
    @endif
    function fnc_supplier_name( operation )
    {
        if (form_validation('txt_supplier_name*txt_short_name','Supplier Name*Short Name')==false)
        {
            return;
        }
        else
        {
            var mandatoryField = "";
            var mandatoryMessage = "";
            @if(session()->has('laravel_stater.mandatory_field.10'))
                mandatoryField = '<?php echo implode('*', session('laravel_stater.mandatory_field.10')); ?>';
                mandatoryMessage = '<?php echo implode('*', session('laravel_stater.mandatory_message.10')); ?>';
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
            var formData = get_form_data('txt_supplier_name,txt_short_name,cbo_country_name,txt_email,txt_website_name,txt_contact_no,txt_contact_person,txt_supplier_address,cbo_tag_company_name,cbo_tag_party_name,update_id');
            var method ="POST";
            var param = "";
            if(operation == 1 || operation == 2)
            {
                param = `/${document.getElementById('update_id').value}`;
                if(operation == 1) formData.append('_method', 'PUT');
                else formData.append('_method', 'DELETE');
            }
            formData.append('_token', '{{csrf_token()}}');
            var url = `/lib/supplier${param}`;
            var requestData = {
                method: method,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                body: formData
            };

            save_update_delete(operation,url,requestData,'id','show_supplier_list_view','list_view_div','mainform_1');
        }
    }

    const load_php_data_to_form =async (menuId) =>
    {
        
        var columns = 'supplier_name*short_name*country_id*tag_company*party_type*contact_person*contact_no*web_site*email*address*id';
        var fields = 'txt_supplier_name*txt_short_name*cbo_country_name*cbo_tag_company_name*cbo_tag_party_name*txt_contact_person*txt_contact_no*txt_website_name*txt_email*txt_supplier_address*update_id';
        var others = '';
       var get_return_value = await populate_form_data('id',menuId,'lib_supplier',columns,fields,'{{csrf_token()}}','','cbo_tag_company_name*cbo_tag_party_name');
       if(get_return_value == 1)
       {
         set_button_status(1, permission, 'fnc_supplier_name',1);
       }
    }

    make_mandatory(10);
    setFilterGrid("list_view",-1);
    
   set_multiselect('cbo_tag_company_name*cbo_tag_party_name','0*0','0*0','','0');

</script>
@endsection
