<?php
//dd(session('laravel_stater.data_arr.8'));
$permission = getPagePermission(request('mid') ?? 0);
$title = getMenuName(request('mid') ?? 0) ?? 'Color Entry';
?>
@extends('layouts.app')
@section('content_header')
<div class="row mb-2">
    <div class="col-sm-12">
        <center><h1 class="m-0 align-center"><strong>{{getMenuName(request('mid') ?? 0) ?? 'Company Location'}}</strong></h1></center>
    </div>
</div>
@endsection()
@section('content')
<div class="container mt-1">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-text">
                        <div class="card p-4" style="background-color:rgb(241, 241, 241);">
                            <form name="locationForm_1" id="locationForm_1" autocomplete="off">
                                <div class="row">
                                    <div class="form-group">
                                        <div class="row d-flex justify-content-center">
                                            <label for="cbo_company_name" class="col-sm-2 col-form-label fw-bold text-start must_entry_caption">Company Name</label>
                                            <div class="col-sm-6 d-flex align-items-center">
                                                <select name="cbo_company_name" id="cbo_company_name" onchange="load_company_config(this.value)" class="form-control">
                                                    <option value="0">SELECT</option>
                                                    <?php $lib_company = App\Models\Company::pluck('company_name', 'id'); ?>
                                                    @foreach($lib_company as $id => $company_name)
                                                    <option value="{{ $id }}">{{ $company_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row d-flex justify-content-center">
                                            <label for="txt_location_name" class="col-sm-2 col-form-label fw-bold text-start must_entry_caption">Location Name</label>
                                            <div class="col-sm-6 d-flex align-items-center">
                                                <input type="text" id="txt_location_name" class="form-control" name="txt_location_name">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row d-flex justify-content-center">
                                            <label for="cbo_country_name" class="col-sm-2 col-form-label fw-bold text-start">Country Name</label>
                                            <div class="col-sm-6 d-flex align-items-center">
                                                <select name="cbo_country_name" id="cbo_country_name" class="form-control">
                                                    <option value="0">SELECT</option>
                                                    <?php $lib_country = App\Models\LibCountry::pluck('country_name', 'id'); ?>
                                                    @foreach($lib_country as $id => $country_name)
                                                    <option value="{{ $id }}">{{ $country_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row d-flex justify-content-center">
                                            <label for="txt_email" class="col-sm-2 col-form-label fw-bold text-start">Email</label>
                                            <div class="col-sm-6 d-flex align-items-center">
                                                <input type="email" id="txt_email" class="form-control" name="txt_email">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row d-flex justify-content-center">
                                            <label for="txt_website_name" class="col-sm-2 col-form-label fw-bold text-start">Website</label>
                                            <div class="col-sm-6 d-flex align-items-center">
                                                <input type="text" id="txt_website_name" class="form-control" name="txt_website_name">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row d-flex justify-content-center">
                                            <label for="txt_contact_no" class="col-sm-2 col-form-label fw-bold text-start">Contact No</label>
                                            <div class="col-sm-6 d-flex align-items-center">
                                                <input type="text" id="txt_contact_no" class="form-control" name="txt_contact_no">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row d-flex justify-content-center">
                                            <label for="txt_contact_person" class="col-sm-2 col-form-label fw-bold text-start">Contact Person</label>
                                            <div class="col-sm-6 d-flex align-items-center">
                                                <input type="text" id="txt_contact_person" class="form-control" name="txt_contact_person">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row d-flex justify-content-center">
                                            <label for="txt_company_address" class="col-sm-2 col-form-label fw-bold text-start">Address</label>
                                            <div class="col-sm-6 d-flex align-items-center">
                                                <input type="text" id="txt_company_address" class="form-control" name="txt_company_address">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 row d-flex justify-content-center mt-2">
                                        <div class="col-sm-2">
                                            <input type="hidden" name="update_id" id="update_id">
                                        </div>
                                        <div class="col-sm-6">
                                            <?php echo load_submit_buttons($permission, "fnc_company_name", 0, 0, "reset_form('locationForm_1','','',1)"); ?>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card table-responsive table-info" id="list_view_div" style="background-color: rgb(241, 241, 241);">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="3%">Sl</th>
                                        <th width="12%">Location Name</th>
                                        <th width="15%">Company Name</th>
                                        <th width="10%">Country Name</th>
                                        <th width="12%">Email</th>
                                        <th width="13%">Website</th>
                                        <th width="13%">Contact No</th>
                                        <th>Address</th>
                                    </tr>
                                </thead>
                                <tbody id="list_view">
                                    <?php
                                    $sl = 1;
                                    $locations = App\Models\LibLocation::get();
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
            </div>
        </div>
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

            save_update_delete(operation,url,requestData,'id','show_location_list_view','list_view_div','locationForm_1');
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
