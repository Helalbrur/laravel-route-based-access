<?php
$permission = getPagePermission(request('mid') ?? 0);
$title = getMenuName(request('mid') ?? 0) ?? 'Color Entry';
?>
@extends('layouts.app')
@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0 align-center"><strong>{{getMenuName(request('mid') ?? 0) ?? 'Buyer Profile'}}</strong></h1>
    </div>
</div>
@endsection()
@section('content')
<div class="container mt-1">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="text-center">Buyer Management</h3>
                    <h5 class="card-title d-flex justify-content-between align-items-center">
                        <a href="{{ url('/lib_buyer_export') }}" class="btn btn-info">Download Format</a>
                        <form action="{{ route('lib_buyer_import') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center">
                            @csrf
                            <input type="file" name="file" required class="form-control me-2">
                            <button type="submit" class="btn btn-info">Import</button>
                        </form>
                    </h5>
                    <div class="card-text">
                        <div class="card p-4" style="background-color:rgb(241, 241, 241)">
                            <form name="buyerForm_1" id="buyerForm_1" autocomplete="off">
                                <div class="row d-flex justify-content-center">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="row d-flex justify-content-center">
                                                <label for="txt_buyer_name" class="col-sm-4 col-form-label fw-bold text-start must_entry_caption">Buyer Name</label>
                                                <div class="col-sm-8 d-flex align-items-center">
                                                    <input type="text" id="txt_buyer_name" class="form-control" name="txt_buyer_name">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row d-flex justify-content-center">
                                                <label for="cbo_country_name" class="col-sm-4 col-form-label fw-bold text-start">Country Name</label>
                                                <div class="col-sm-8 d-flex align-items-center">
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
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row d-flex justify-content-center">
                                                <label for="txt_website_name" class="col-sm-4 col-form-label fw-bold text-start">Website</label>
                                                <div class="col-sm-8 d-flex align-items-center">
                                                    <input type="text" id="txt_website_name" class="form-control" name="txt_website_name">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row d-flex justify-content-center">
                                                <label for="txt_contact_person" class="col-sm-4 col-form-label fw-bold text-start">Contact Person</label>
                                                <div class="col-sm-8 d-flex align-items-center">
                                                    <input type="text" id="txt_contact_person" class="form-control" name="txt_contact_person">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row d-flex justify-content-center">
                                                <label for="cbo_tag_company_name"  class="col-sm-4 col-form-label fw-bold text-start">Tag Company Name</label>
                                                <div class="col-sm-8 d-flex align-items-center">
                                                    <select name="cbo_tag_company_name[]" id="cbo_tag_company_name"  class="form-control" multiple="multiple">
                                                        <option value="0">SELECT</option>
                                                        <?php $lib_company = App\Models\Company::pluck('company_name', 'id'); ?>
                                                        @foreach($lib_company as $id => $company_name)
                                                            <option value="{{ $id }}">{{ $company_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="row d-flex justify-content-center">
                                                <label for="txt_short_name" class="col-sm-4 col-form-label fw-bold text-start must_entry_caption">Short Name</label>
                                                <div class="col-sm-8 d-flex align-items-center">
                                                    <input type="text" id="txt_short_name" class="form-control" name="txt_short_name">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row d-flex justify-content-center">
                                                <label for="txt_email" class="col-sm-4 col-form-label fw-bold text-start">Email</label>
                                                <div class="col-sm-8 d-flex align-items-center">
                                                    <input type="email" id="txt_email" class="form-control" name="txt_email">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row d-flex justify-content-center">
                                                <label for="txt_contact_no" class="col-sm-4 col-form-label fw-bold text-start">Contact No</label>
                                                <div class="col-sm-8 d-flex align-items-center">
                                                    <input type="text" id="txt_contact_no" class="form-control" name="txt_contact_no">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row d-flex justify-content-center">
                                                <label for="txt_buyer_address" class="col-sm-4 col-form-label fw-bold text-start">Address</label>
                                                <div class="col-sm-8 d-flex align-items-center">
                                                    <input type="text" id="txt_buyer_address" class="form-control" name="txt_buyer_address">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row d-flex justify-content-center">
                                                <label for="cbo_tag_party_name"  class="col-sm-4 col-form-label fw-bold text-start">Tag Party Name</label>
                                                <div class="col-sm-8 d-flex align-items-center">
                                                    <select name="cbo_tag_party_name[]" id="cbo_tag_party_name" class="form-control" multiple="multiple">
                                                        <?php $party_types =party_type(); ?>
                                                        @foreach($party_types as $id => $party_name)
                                                            <option value="{{ $id }}">{{ $party_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2 row d-flex justify-content-center">
                                    <div class="col-sm-2">
                                        <input type="hidden" name="update_id" id="update_id">
                                    </div>
                                    <div class="col-sm-6">
                                        <?php echo load_submit_buttons($permission, "fnc_buyer_name", 0, 0, "reset_form('buyerForm_1','','',1)"); ?>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card table-responsive table-info mx-auto p-3 mt-4" style="background-color:rgb(241, 241, 241);" id="list_view_div">
                        <table class="table table-bordered table-striped text-center">
                            <thead class="table-secondary">
                                <tr>
                                    <th width="3%">Sl</th>
                                    <th width="12%">Buyer Name</th>
                                    <th width="15%">Company Name</th>
                                    <th width="10%">Country Name</th>
                                    <th width="12%">Email</th>
                                    <th width="13%">Website</th>
                                    <th width="13%">Contact No</th>
                                    <th>Address</th>
                                </tr>
                            </thead>
                            <tbody id="list_view">
                                @foreach(App\Models\LibBuyer::get() as $index => $buyer)
                                <tr id="tr_{{ $index + 1 }}" onclick="load_php_data_to_form('{{ $buyer->id }}')" style="cursor:pointer">
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $buyer->buyer_name }}</td>
                                    <td>{{ implode(', ', $buyer->company->pluck('company_name')->toArray()) }}</td>
                                    <td>{{ $buyer->country->country_name ?? '' }}</td>
                                    <td>{{ $buyer->email }}</td>
                                    <td>{{ $buyer->website }}</td>
                                    <td>{{ $buyer->contact_no }}</td>
                                    <td>{{ $buyer->address }}</td>
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
@endsection

@section('script')
<script>
     var permission ='{{$permission}}';
     var field_level_data = "";
     @if(session()->has('laravel_stater.data_arr.9'))
        @php
            $dataArr = json_encode(session('laravel_stater.data_arr.9'));
            echo "field_level_data = ".$dataArr.";\n";
        @endphp
    @endif
    function fnc_buyer_name( operation )
    {
        if (form_validation('txt_buyer_name*txt_short_name','Buyer Name*Short Name')==false)
        {
            return;
        }
        else
        {
            var mandatoryField = "";
            var mandatoryMessage = "";
            @if(session()->has('laravel_stater.mandatory_field.9'))
                mandatoryField = '<?php echo implode('*', session('laravel_stater.mandatory_field.9')); ?>';
                mandatoryMessage = '<?php echo implode('*', session('laravel_stater.mandatory_message.9')); ?>';
            @endif

            if (mandatoryField)
            {
                if (form_validation(mandatoryField, mandatoryMessage) == false)
                {
                    return;
                }
            }
            var formData = get_form_data('txt_buyer_name,txt_short_name,cbo_country_name,txt_email,txt_website_name,txt_contact_no,txt_contact_person,txt_buyer_address,cbo_tag_company_name,cbo_tag_party_name,update_id');
            var method ="POST";
            var param = "";
            if(operation == 1 || operation == 2)
            {
                param = `/${document.getElementById('update_id').value}`;
                if(operation == 1) formData.append('_method', 'PUT');
                else formData.append('_method', 'DELETE');
            }
            formData.append('_token', '{{csrf_token()}}');
            var url = `/lib/buyer${param}`;
            var requestData = {
                method: method,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                body: formData
            };

            save_update_delete(operation,url,requestData,'id','show_buyer_list_view','list_view_div','mainform_1');
        }
    }

    const load_php_data_to_form =async (menuId) =>
    {
        
        var columns = 'buyer_name*short_name*country_id*tag_company*party_type*contact_person*contact_no*web_site*email*address*id';
        var fields = 'txt_buyer_name*txt_short_name*cbo_country_name*cbo_tag_company_name*cbo_tag_party_name*txt_contact_person*txt_contact_no*txt_website_name*txt_email*txt_buyer_address*update_id';
        var others = '';
       //var get_return_value = await populate_form_data('id',menuId,'lib_buyer',columns,fields,'{{csrf_token()}}','','cbo_tag_company_name*cbo_tag_party_name');

       var get_return_value = await populate_form_data('id',menuId,'lib_buyer',columns,fields,'{{csrf_token()}}','','');
       if(get_return_value == 1)
       {
         set_button_status(1, permission, 'fnc_buyer_name',1);
       }
    }

    make_mandatory(9);
    setFilterGrid("list_view",-1);
    
   //set_multiselect('cbo_tag_company_name*cbo_tag_party_name','0*0','0*0','','0');

</script>
@endsection
