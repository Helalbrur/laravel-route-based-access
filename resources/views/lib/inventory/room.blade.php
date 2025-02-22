<?php
$permission = getPagePermission(request('mid') ?? 0);
?>
@extends('layouts.app')
@section('content_header')
<div class="row mb-2">
    <div class="col-sm-12 d-flex justify-content-center">
        <h1 class="m-0 text-center"><strong>{{getMenuName(request('mid') ?? 0) ?? 'Room'}}</strong></h1>
    </div>
</div>
@endsection()
@section('content')
<div class="container mt-1">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-body">
                    <div class="card-text">
                        <div class="card pt-4 px-4" style="background-color: rgb(241, 241, 241);">
                            <form name="libroom_1" id="libroom_1" autocomplete="off">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group row d-flex justify-content-center">
                                            <label for="cbo_company_name" class="col-sm-3 col-form-label fw-bold text-start must_entry_caption">Company Name</label>
                                            <div class="col-sm-8">
                                                <select name="cbo_company_name" id="cbo_company_name" onchange="load_drop_down('load_drop_down', this.value+'*store_under_location*store_div', 'location_under_company', 'location_div')" class="form-control">
                                                    <option value="0">SELECT</option>
                                                    <?php
                                                    $lib_company = App\Models\Company::pluck('company_name', 'id');
                                                    ?>
                                                    @foreach($lib_company as $id => $company_name)
                                                    <option value="{{ $id }}">{{ $company_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row d-flex justify-content-center">
                                            <label for="cbo_location_name" class="col-sm-3 col-form-label fw-bold text-start must_entry_caption">Location</label>
                                            <div class="col-sm-8" id="location_div">
                                                <select name="cbo_location_name" id="cbo_location_name" class="form-control">
                                                    <option value="0">SELECT</option>
                                                    <?php
                                                    $lib_location = App\Models\LibLocation::pluck('location_name', 'id');
                                                    ?>
                                                    @foreach($lib_location as $id => $location_name)
                                                    <option value="{{ $id }}">{{ $location_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row d-flex justify-content-center">
                                            <label for="cbo_store_name" class="col-sm-3 col-form-label fw-bold text-start must_entry_caption">Store Name</label>
                                            <div class="col-sm-8" id="store_div">
                                                <?php $stores = App\Models\LibStoreLocation::get(); ?>
                                                <select name="cbo_store_name" id="cbo_store_name" class="form-control">
                                                    <option value="0">SELECT</option>
                                                    @foreach($stores as $store)
                                                    <option value="{{$store->id}}">{{$store->store_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row d-flex justify-content-center">
                                            <label for="cbo_floor_name" class="col-sm-3 col-form-label fw-bold text-start must_entry_caption">Floor</label>
                                            <div class="col-sm-8" id="location_div">
                                                <select name="cbo_floor_name" id="cbo_floor_name" class="form-control">
                                                    <option value="0">SELECT</option>
                                                    <?php
                                                    $lib_floor = App\Models\LibFloor::pluck('floor_name', 'id');
                                                    ?>
                                                    @foreach($lib_floor as $id => $floor_name)
                                                    <option value="{{ $id }}">{{ $floor_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row d-flex justify-content-center">
                                            <label for="txt_room_no" class="col-sm-3 col-form-label fw-bold text-start">Room No</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="txt_room_no" name="txt_room_no">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row d-flex justify-content-center mt-4">
                                    <div class="col-sm-4">
                                        <input type="hidden" value="" name="update_id" id="update_id">
                                    </div>
                                    <div class="col-sm-8">
                                        <?php echo load_submit_buttons($permission, "fnc_lib_room", 0, 0, "reset_form('libroom_1','','',1,'')"); ?>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card table-responsive table-info mx-auto p-3 mt-4" style="background-color: rgb(241, 241, 241);" id="list_view_div">
                            <table class="table table-bordered table-striped text-center">
                                <thead class="table-secondary">
                                    <tr>
                                        <th width="5%">Sl</th>
                                        <th width="25%">Company Name</th>
                                        <th width="20%">Location Name</th>
                                        <th width="20%">Store</th>
                                        <th width="15%">Floor Name</th>
                                        <th>Room No</th>
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
                                        ->select('a.id', 'd.store_name', 'e.company_name', 'c.location_name', 'f.floor_name', 'a.floor_room_rack_name as room_no')
                                        ->whereNull('a.deleted_at')
                                        ->whereNull('b.deleted_at')
                                        ->get();
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
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    var permission = '{{$permission}}';

    function fnc_lib_room(operation) 
    {
        if (form_validation('cbo_floor_name*cbo_company_name*cbo_location_name*cbo_store_name*txt_room_no', 'Floor Name*Company Name*Location*Store Name*Room Name') == false) {
            return;
        } else {
            var formData = get_form_data('cbo_floor_name,cbo_company_name,cbo_location_name,cbo_store_name,txt_room_no,update_id');
            var method = "POST";
            var param = "";
            if (operation == 1 || operation == 2) {
                param = `/${document.getElementById('update_id').value}`;
                if (operation == 1) formData.append('_method', 'PUT');
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
            save_update_delete(operation, url, requestData, 'id', 'show_room_list_view', 'list_view_div', 'libroom_1');
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
            triggerChangeEvent('cbo_company_name'); // Trigger change based on condition
            await waitForDropdownUpdate('cbo_location_name', data.location_id); // Wait for correct location
            triggerChangeEvent('cbo_location_name');

 
            await waitForDropdownUpdate('cbo_store_name', data.store_id); // Wait for correct store
            // 🏃 Store -> Floor
            triggerChangeEvent('cbo_store_name');


            await waitForDropdownUpdate('cbo_floor_name', data.floor_id); // Wait for correct floor
            // 🏃 Floor (final)
            triggerChangeEvent('cbo_floor_name');

            document.getElementById('txt_room_no').value = data.room_no;
            document.getElementById('update_id').value = data.id;

            set_button_status(1, permission, 'fnc_lib_room', 1);
        } catch (error) {
            console.error('Error:', error);
        }
    }

    setFilterGrid("list_view", -1);
</script>
@endsection