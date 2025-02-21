<?php

$permission = getPagePermission(request('mid') ?? 0);
?>
@extends('layouts.app')
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-12">
            <center><h1 class="m-0 align-center"><strong>{{getMenuName(request('mid') ?? 0) ?? 'Room'}}</strong></h1></center>
        </div>
    </div>
@endsection()
@section('content')
<div class="row">
    <div class="col-lg-12">
        <center>
            <div class="card" style="justify-content:center;width: 80%;">
                <div class="card-body" style="justify-content:center;">
                    <div class="card-text" style="justify-content:center;">
                        <!-- #EBF4FA; -->
                        <div class="card" style="background-color: #F5FFFA;justify-content:center;text-align:center">
                            <form name="libroom_1" id="libroom_1" autocomplete="off" style="padding: 10px;">
                                <div class="form-group row">
                                   
                                    <label for="cbo_company_name"  class="col-sm-2 col-form-label must_entry_caption">Company Name</label>
                                    <div class="col-sm-4">
                                        <select name="cbo_company_name" id="cbo_company_name" onchange="load_drop_down( 'load_drop_down', this.value+'*store_under_location*store_div', 'location_under_company', 'location_div' )" class="form-control">
                                            <option value="0">SELECT</option>
                                            <?php
                                                $lib_company = App\Models\Company::pluck('company_name', 'id');
                                            ?>
                                            @foreach($lib_company as $id => $company_name)
                                                <option value="{{ $id }}">{{ $company_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <label for="cbo_location_name"  class="col-sm-2 col-form-label must_entry_caption">Location</label>
                                    <div class="col-sm-4" id="location_div">
                                        <select name="cbo_location_name" id="cbo_location_name"  class="form-control">
                                            <option value="0">SELECT</option>
                                            <?php
                                                $lib_location = App\Models\LibLocation::pluck('location_name','id');
                                            ?>
                                            @foreach($lib_location as $id => $location_name)
                                                <option value="{{ $id }}">{{ $location_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                   
                                    <label for="cbo_store_name" class="col-sm-2 col-form-label must_entry_caption"> Store Name</label>
                                    <div class="col-sm-4" id="store_div">
                                        <?php
                                            $stores = App\Models\LibStoreLocation::get();
                                            ?>
                                        <select name="cbo_store_name" id="cbo_store_name" class="form-control">
                                            <option value="0">SELECT</option>
                                            @foreach($stores as $store)
                                                <option value="{{$store->id}}" >{{$store->store_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <label for="cbo_floor_name"  class="col-sm-2 col-form-label must_entry_caption">Floor</label>
                                    <div class="col-sm-4" id="location_div">
                                        <select name="cbo_floor_name" id="cbo_floor_name"  class="form-control">
                                            <option value="0">SELECT</option>
                                            <?php
                                                $lib_floor = App\Models\LibFloor::pluck('floor_name','id');
                                            ?>
                                            @foreach($lib_floor as $id => $floor_name)
                                                <option value="{{ $id }}">{{ $floor_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                   
                                    <label for="txt_room_no"  class="col-sm-2 col-form-label ">Room No</label>
                                    <div class="col-sm-4" >
                                        <input type="text" class="form-control" id="txt_room_no" name="txt_room_no">
                                    </div>
                                    
                                    
                                </div>
                                <div class="from-group row" style="margin-top: 20px;">
                                    <div class="col-sm-12">
                                        <input type="hidden" value="" name="update_id" id="update_id"/>
                                    
                                        <?php
                                            echo load_submit_buttons( $permission, "fnc_lib_room", 0,0 ,"reset_form('libroom_1','','',1,'')");
                                        ?>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div style="margin:auto;padding:10px;background-color:#F5FFFA;justify-content:center;text-align:center" class="card table-responsive table-info" align="center" id="list_view_div">
                        <table class="table table-bordered table-striped" >
                            <thead>
                                <tr>
                                    <th width="10%">Sl</th>
                                    <th width="15%">Company Name</th>
                                    <th width="20%">Location Name</th>
                                    <th width="20%">Store</th>
                                    <th width="15%">Floor Name</th>
                                    <th >Room No</th>
                                    
                                </tr>
                            </thead>
                            <tbody id="list_view">
                                <?php
                                    $sl = 1;
                                    $rooms = DB::table('lib_floor_room_rack_mst as a')
                                                ->join('lib_floor_room_rack_dtls as b', 'a.id', 'b.room_id')
                                                ->leftJoin('lib_location as c', 'b.location_id', 'c.id')
                                                ->leftJoin('lib_store_location as d', 'b.store_id', 'd.id')
                                                ->leftJoin('lib_company as e', 'a.company_id', 'e.id')
                                                ->leftJoin('lib_floor as f', 'b.floor_id', 'f.id')
                                                ->select(
                                                    'a.id',
                                                    'd.store_name',
                                                    'e.company_name',
                                                    'c.location_name',
                                                    'f.floor_name',
                                                    'a.floor_room_rack_name as room_no'
                                                )
                                                ->whereNull('a.deleted_at')  
                                                ->whereNull('b.deleted_at') 
                                                ->get();
                                                //->ddRawSql();
                                ?>

                                @foreach($rooms as $room)
                                    <tr id="tr_{{$sl}}" onclick="load_php_data_to_form('{{$room->id}}')" style="cursor:pointer">
                                        <td>{{$sl++}}</td>
                                        <td>{{$room->company_name}}</td>
                                        <td>{{$room->location_name}}</td>
                                        <td>{{$room->store_name}}</td>
                                        <td>{{$room->floor_name}}</td>
                                        <td>{{$room->room_no}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </div>
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
    function fnc_lib_room( operation )
    {
        if (form_validation('cbo_floor_name*cbo_company_name*cbo_location_name*cbo_store_name*txt_room_no','Floor Name* Company Name*Location*Store Name')==false)
        {
            return;
        }
        else
        {
            var formData = get_form_data('cbo_floor_name,cbo_company_name,cbo_location_name,cbo_store_name,txt_room_no,update_id');
            var method ="POST";
            var param = "";
            if(operation == 1 || operation == 2)
            {
                param = `/${document.getElementById('update_id').value}`;
                if(operation == 1) formData.append('_method', 'PUT');
                else formData.append('_method', 'DELETE');
            }
            formData.append('_token', '{{csrf_token()}}');
            var url = `/lib/inventory/room${param}`;
            var requestData = {
                method: method,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                body: formData
            };

            save_update_delete(operation,url,requestData,'id','show_room_list_view','list_view_div','libroom_1');
        }
    }

    async function load_php_data_to_form(room_id) {
        try {
            reset_form('libroom_1', '', '', 1);
            const response = await fetch(`/room_details/${room_id}`);
            if (!response.ok) throw new Error('Failed to fetch data');
            const data = await response.json();
            console.log(data);

            // 🏃 Company -> Location
            $('#cbo_company_name').val(data.company_id);
            triggerChangeEvent('#cbo_company_name');  // Trigger change based on condition
            await waitForDropdownUpdate('#cbo_location_name', data.location_id); // Wait for correct location

            // 🏃 Location -> Store
            //$('#cbo_location_name').val(data.location_id);
            triggerChangeEvent('#cbo_location_name');
            await waitForDropdownUpdate('#cbo_store_name', data.store_id); // Wait for correct store

            // 🏃 Store -> Floor
            //$('#cbo_store_name').val(data.store_id);
            triggerChangeEvent('#cbo_store_name');
            await waitForDropdownUpdate('#cbo_floor_name', data.floor_id); // Wait for correct floor

            // 🏃 Floor (final)
            //$('#cbo_floor_name').val(data.floor_id);
            triggerChangeEvent('#cbo_floor_name');
            document.getElementById('txt_room_no').value = data.room_no;
            document.getElementById('update_id').value = data.id;

            set_button_status(1, permission, 'fnc_lib_room', 1);
        } catch (error) {
            console.error('Error:', error);
        }
    }

    async function waitForDropdownUpdate(selector, expectedValue, timeout = 100) {
        return new Promise((resolve, reject) => {
            const targetNode = $(selector)[0];  // jQuery object to DOM element
            if (!targetNode) return reject(`Element ${selector} not found`);

            const observer = new MutationObserver(() => {
                const optionExists = [...targetNode.options].some(opt => opt.value == expectedValue);
                console.log(`Checking ${selector} for value ${expectedValue}:`, optionExists);

                if (optionExists) {
                    // Use Select2's val method to set value and trigger appropriate event
                    $(selector).val(expectedValue);
                    triggerChangeEvent(selector);  // Trigger Select2 or regular change event based on condition
                    observer.disconnect();
                    console.log(`${selector} resolved with value: ${expectedValue}`);
                    resolve();
                }
            });

            // Observe for options being added
            observer.observe(targetNode, { childList: true, subtree: true });

            // Safety timeout
            setTimeout(() => {
                observer.disconnect();
                const finalCheck = [...targetNode.options].some(opt => opt.value == expectedValue);
                if (finalCheck) {
                    $(selector).val(expectedValue);
                    triggerChangeEvent(selector);
                    console.log(`${selector} resolved after timeout with value: ${expectedValue}`);
                    resolve();
                } else {
                    reject(`Timeout: ${selector} did not resolve to ${expectedValue}`);
                }
            }, timeout);
        });
    }

    setFilterGrid("list_view",-1);
   
</script>
@endsection
