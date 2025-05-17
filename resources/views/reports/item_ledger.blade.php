<?php
$title = getMenuName(request('mid') ?? 0) ?? 'Item Ledger';
?>
@extends('layouts.app')
@section('content_header')
<div class="row">
    <div class="col-sm-12">
        <center><h1 class="m-0 align-center"><strong>{{ getMenuName(request('mid') ?? 0) ?? 'Item Ledger'}}</strong></h1></center>
    </div>
</div>
<style>
    .custom-striped tr:nth-child(odd) {
        background-color: rgba(0, 0, 0, 0.05);
    }
    table{
        width: 100%;
        margin-bottom: 1rem;
        color: #212529;
        border-collapse: collapse;
        border: 1px solid #dee2e6;
    }
</style>
@endsection()
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-text">
                        <div class="card p-4" style="background-color: rgb(241, 241, 241);">
                            <table id="list_view" class="table table-striped" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th width ="10%">Company</th>
                                        <th width ="10%">Item Category</th>
                                        <th width ="15%">Item Name</th>
                                        <th width ="10%">Item Code</th>
                                        <th width ="10%">Origin</th>
                                        <th width ="10%">Generic Name</th>
                                        <th width ="20%" colspan="2">Date</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <select style="width: 100%" name="cbo_company_name" id="cbo_company_name" class="form-control" >
                                                <option value="0">SELECT</option>
                                                <?php $lib_company = App\Models\Company::pluck('company_name', 'id'); ?>
                                                @foreach($lib_company as $id => $company_name)
                                                <option value="{{ $id }}">{{ $company_name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-control form-control-sm" id="cbo_item_category" name="cbo_item_category" style="width: 100%">
                                                <option value="">--All--</option>
                                                @foreach(get_item_category() as $category_id => $category_name)
                                                    <option value="{{$category_id}}" >{{$category_name}}</option>
                                                @endforeach
                                            </select>
                                        </td>

                                        <td >
                                            <input type="text" class="form-control form-control-sm" id="txt_product_name" name="txt_product_name" value="" placeholder="Item Name" ondblclick="fnc_product_name()"  placeholder="Write / Double Click" style="width: 100%">
                                            <input type="hidden" name="hidden_product_id" id="hidden_product_id" class="form-control" value="">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-sm" id="txt_item_code" name="txt_item_code" value="" placeholder="Item Code">
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
                                            <input type="text" class="form-control flatpickr" id="txt_date_from" name="txt_date_from" value="" placeholder="From Date">
                                            
                                        </td>
                                        <td>
                                            <input type="text" class="form-control flatpickr" id="txt_date_to" name="txt_date_to" value="" placeholder="To Date">
                                        </td>
                                        <td>
                                            
                                            <input type="button" name="button2" class="formbutton btn btn-sm btn-info" value="Show" onClick="generate_report(1)" title="Click to Show" style="width:70px;" />
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
    </div>
</div>
@endsection

@section('script')
<script>
    async function handleCategoryChange() {
        try {
            await load_drop_down_v2('load_drop_down',JSON.stringify({'category_id':document.getElementById('cbo_item_category').value,'onchange':'','class':'form-control form-control-sm'}), 'product_under_category', 'product_div')
        } catch (error) {
            console.error('Error loading dropdown:', error);
        }
    }

    

    function fnc_product_name()
    {
        if(form_validation('cbo_company_name*cbo_item_category','Company Name*Item Category')==false)
        {
            return;
        }
        
        var param = JSON.stringify({
            'company_id': $("#cbo_company_name").val(),
            'category_id': $("#cbo_item_category").val(),
            'item_code': $("#txt_item_code").val(),
            'item_origin': $("#txt_origin").val(),
            'generic_id': $("#cbo_generic_name").val()
        });
        console.log(param);
        var title = 'Item Search';
        var page_link= getBaseUrl() +'/show_common_popup_view?page=item_ledger_product_search_list_view&param='+param;
        emailwindow=dhtmlmodal.open('EmailBox', 'iframe', page_link, title, 'width=800px,height=370px,center=1,resize=1,scrolling=1','../');
        emailwindow.onclose=function()
        {
            try
            {
                var popup_value=this.contentDoc.getElementById("popup_value").value;	 //Access form field
                var product_arr = JSON.parse(popup_value);
                /*
                     $param = json_encode(array('product_id'=>$product->id,
                                          'item_code'=>$product->item_code,
                                          'item_name'=>$product->item_description,
                                          'category_id'=>$product->item_category_id,
                                          'uom_id'=>$product->order_uom,
                                          'current_rate'=>$product->avg_rate_per_unit));
                */
                console.log(product_arr);
                $('#txt_product_name').val(product_arr.item_name);
                $('#hidden_product_id').val(product_arr.product_id);
                $('#txt_item_code').val(product_arr.item_code);
                $('#txt_origin').val(product_arr.item_origin);
                $('#cbo_generic_name').val(product_arr.generic_id);
               
            } catch (error) {
                console.error('Error:', error);
                
            }
        }
    }

    function generate_report(type = 1)
    {
        

        var formData = get_form_data('cbo_company_name,cbo_item_category,txt_product_name,txt_item_code,txt_origin,cbo_generic_name,txt_date_from,txt_date_to,hidden_product_id');
        var method = "POST";
        formData.append('_token', '{{csrf_token()}}');
        formData.append('type', type);
        var url = getBaseUrl() + "/reports/item-ledger";
        var requestData = {
            method: method,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            },
            body: formData
        };

        //call fetch post request to generate report
        fetch(url, requestData)
        .then(response => response.text())
        .then(html => {
            document.getElementById('search_div').innerHTML = html;
        })
        .catch(error => console.error('Error loading details:', error));
       
    }
    // Modified print preview function with proper styling
    function print_preview() {
        const printContent = document.getElementById('item_ledger_report').cloneNode(true);
        // const styles = Array.from(document.querySelectorAll('style, link[rel="stylesheet"]'))
        //     .map(el => el.outerHTML)
        //     .join('');

        const printWindow = window.open('', '_blank');
        printWindow.document.write(printContent.innerHTML);
        printWindow.document.close();
    }


    function excel_download() {
        // Get current report HTML
        const reportHtml = document.getElementById('item_ledger_report').outerHTML;
        const BASE_URL = getBaseUrl();
        var url = "{{ route('item-ledger.excel') }}";
        // Send HTML to server for conversion
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ html: reportHtml })
        })
        .then(response => response.blob())
        .then(blob => {
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'item-ledger.xlsx';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        })
        .catch(error => shoshowNotification(error,'error'));
    }
</script>
@endsection