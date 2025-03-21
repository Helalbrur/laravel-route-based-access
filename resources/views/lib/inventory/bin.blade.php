<?php
use App\Models\LibFloorRoomRackMst; 
$permission = getPagePermission(request('mid') ?? 0);
?>
@extends('layouts.app')
@section('content_header')
<div class="row mb-2">
    <div class="col-sm-12 d-flex justify-content-center">
        <h1 class="m-0 text-center"><strong>{{getMenuName(request('mid') ?? 0) ?? 'Bin'}}</strong></h1>
    </div>
</div>
@endsection()
@section('content')
<div class="container mt-1">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-text">
                        <div class="card pt-4 px-4" style="background-color: rgb(241, 241, 241);">
                            <form name="libBin_1" id="libBin_1" autocomplete="off">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group row d-flex justify-content-center">
                                            <label for="txt_bin_no" class="col-sm-3 col-form-label fw-bold text-start must_entry_caption">Bin No</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="txt_bin_no" name="txt_bin_no">
                                            </div>
                                        </div>
                                        <div class="form-group row d-flex justify-content-center">
                                            <label for="cbo_company_name" class="col-sm-3 col-form-label fw-bold text-start must_entry_caption">Company Name</label>
                                            <div class="col-sm-8 d-flex align-items-center">
                                                <select name="cbo_company_name" id="cbo_company_name" onchange="handleCompanyChange()" class="form-control">
                                                    <option value="0">SELECT</option>
                                                    <?php $lib_company = App\Models\Company::pluck('company_name', 'id'); ?>
                                                    @foreach($lib_company as $id => $company_name)
                                                    <option value="{{ $id }}">{{ $company_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row d-flex justify-content-center">
                                            <label for="cbo_location_name" class="col-sm-3 col-form-label fw-bold text-start must_entry_caption">Location</label>
                                            <div class="col-sm-8 d-flex align-items-center" id="location_div">
                                                <select name="cbo_location_name" id="cbo_location_name" class="form-control">
                                                    <option value="0">SELECT</option>
                                                    <?php $lib_location = App\Models\LibLocation::pluck('location_name', 'id'); ?>
                                                    @foreach($lib_location as $id => $location_name)
                                                    <option value="{{ $id }}">{{ $location_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row d-flex justify-content-center">
                                            <label for="cbo_store_name" class="col-sm-3 col-form-label fw-bold text-start must_entry_caption">Store Name</label>
                                            <div class="col-sm-8 d-flex align-items-center" id="store_div">
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
                                            <label for="cbo_floor_name" class="col-sm-3 col-form-label fw-bold text-start must_entry_caption">Floor Name</label>
                                            <div class="col-sm-8 d-flex align-items-center" id="floor_div">
                                                <?php $floors = App\Models\LibFloor::get(); ?>
                                                <select name="cbo_floor_name" id="cbo_floor_name" class="form-control">
                                                    <option value="0">SELECT</option>
                                                    @foreach($floors as $floor)
                                                    <option value="{{$store->id}}">{{$floor->floor_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row d-flex justify-content-center">
                                            <label for="cbo_room_no" class="col-sm-3 col-form-label fw-bold text-start must_entry_caption">Room No</label>
                                            <div class="col-sm-8 d-flex align-items-center" id="room_div">
                                                <?php 
                                                    $rooms = LibFloorRoomRackMst::whereHas('room_details')->get(); 
                                                ?>
                                                <select name="cbo_room_no" id="cbo_room_no" class="form-control">
                                                    <option value="0">SELECT</option>
                                                    @foreach($rooms as $room)
                                                        <option value="{{$room->id}}">{{$room->floor_room_rack_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row d-flex justify-content-center">
                                            <label for="cbo_rack_no" class="col-sm-3 col-form-label fw-bold text-start must_entry_caption">Rack No</label>
                                            <div class="col-sm-8 d-flex align-items-center" id="rack_div">
                                                <?php 
                                                    $racks = LibFloorRoomRackMst::whereHas('rack_details')->get(); 
                                                ?>
                                                <select name="cbo_rack_no" id="cbo_rack_no" class="form-control">
                                                    <option value="0">SELECT</option>
                                                    @foreach($racks as $rack)
                                                        <option value="{{$rack->id}}">{{$rack->floor_room_rack_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row d-flex justify-content-center">
                                            <label for="cbo_shelf_no" class="col-sm-3 col-form-label fw-bold text-start must_entry_caption">Shelf No</label>
                                            <div class="col-sm-8 d-flex align-items-center" id="shelf_div">
                                                <?php 
                                                    $shelfs = LibFloorRoomRackMst::whereHas('shelf_details')->get(); 
                                                ?>
                                                <select name="cbo_shelf_no" id="cbo_shelf_no" class="form-control">
                                                    <option value="0">SELECT</option>
                                                    @foreach($shelfs as $shelf)
                                                        <option value="{{$shelf->id}}">{{$shelf->floor_room_rack_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row d-flex justify-content-center mt-4">
                                    <div class="col-sm-4">
                                        <input type="hidden" value="" name="update_id" id="update_id">
                                    </div>
                                    <div class="col-sm-8">
                                        <?php echo load_submit_buttons($permission, "fnc_lib_rack", 0, 0, "reset_form('libBin_1','','',1,'')"); ?>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card table-responsive table-info mx-auto p-3 mt-4" style="background-color: rgb(241, 241, 241);" id="list_view_div">
                            <table class="table table-bordered table-striped text-center">
                                <thead class="table-secondary">
                                    <tr>
                                        <th width="5%">Sl</th>
                                        <th width="15%">Company Name</th>
                                        <th width="13%">Location Name</th>
                                        <th width="13%">Store</th>
                                        <th width="13%">Floor Name</th>
                                        <th width="10%">Room No</th>
                                        <th width="10%">Rack No</th>
                                        <th width="10%">Shelf No</th>
                                        <th>Bin No</th>
                                    </tr>
                                </thead>
                                <tbody id="list_view">
                                    <?php
                                    use Illuminate\Support\Facades\DB;

                                    $sl = 1;
                                    
                                    $bins = DB::table('lib_floor_room_rack_mst as a')
                                        ->join('lib_floor_room_rack_dtls as b', 'a.id', 'b.bin_id')
                                        ->leftJoin('lib_location as c', 'b.location_id', 'c.id')
                                        ->leftJoin('lib_store_location as d', 'b.store_id', 'd.id')
                                        ->leftJoin('lib_company as e', 'a.company_id', 'e.id')
                                        ->leftJoin('lib_floor as f', 'b.floor_id', 'f.id')
                                        ->leftJoin('lib_floor_room_rack_mst as room', 'b.room_id', 'room.id')
                                        ->leftJoin('lib_floor_room_rack_mst as rack', 'b.rack_id', 'rack.id')
                                        ->leftJoin('lib_floor_room_rack_mst as shelf', 'b.shelf_id', 'shelf.id')
                                        ->leftJoin('lib_floor_room_rack_mst as bin', 'b.bin_id', 'bin.id')
                                        ->select(
                                            'a.id',
                                            'd.store_name',
                                            'e.company_name',
                                            'c.location_name',
                                            'f.floor_name',
                                            'room.floor_room_rack_name as room_no',
                                            'rack.floor_room_rack_name as rack_no',
                                            'shelf.floor_room_rack_name as shelf_no',
                                            'bin.floor_room_rack_name as bin_no'
                                        )
                                        ->whereNull('a.deleted_at')
                                        ->whereNull('b.deleted_at')
                                        ->get();
                                    
                                    ?>
                                    @foreach($bins as $bin)
                                    <tr id="tr_{{$sl}}" onclick="load_php_data_to_form('{{$bin->id}}')" style="cursor:pointer">
                                        <td>{{$sl++}}</td>
                                        <td>{{$bin->company_name}}</td>
                                        <td>{{$bin->location_name}}</td>
                                        <td>{{$bin->store_name}}</td>
                                        <td>{{$bin->floor_name}}</td>
                                        <td>{{$bin->room_no}}</td>
                                        <td>{{$bin->rack_no}}</td>
                                        <td>{{$bin->shelf_no}}</td>
                                        <td>{{$bin->bin_no}}</td>
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
    function fnc_lib_rack( operation )
    {
        if (form_validation('txt_bin_no*cbo_company_name*cbo_location_name*cbo_store_name*cbo_floor_name*cbo_room_no*cbo_rack_no*cbo_shelf_no','Bin No*Company Name*Location*Store Name*Floor Name*Room No*Rack No*Bin No')==false)
        {
            return;
        }
        else
        {
            var formData = get_form_data('txt_bin_no,cbo_company_name,cbo_location_name,cbo_store_name,cbo_floor_name,cbo_room_no,cbo_rack_no,cbo_shelf_no,update_id');
            var method ="POST";
            var param = "";
            if(operation == 1 || operation == 2)
            {
                param = `/${document.getElementById('update_id').value}`;
                if(operation == 1) formData.append('_method', 'PUT');
                else formData.append('_method', 'DELETE');
            }
            formData.append('_token', '{{csrf_token()}}');
            var url = `/lib/inventory/bin${param}`;
            var requestData = {
                method: method,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                body: formData
            };

            save_update_delete(operation,url,requestData,'id','show_bin_list_view','list_view_div','libBin_1');
        }
    }

    async function load_php_data_to_form(bin_id) {
        try {
            freeze_window(3);
            reset_form('libBin_1', '', '', 1);
            const response = await fetch(`/bin_details/${bin_id}`);
            if (!response.ok) throw new Error('Failed to fetch data');
            const data = await response.json();
            console.log(data);

            $('#cbo_company_name').val(data.company_id);
            await handleCompanyChange();

            $('#cbo_location_name').val(data.location_id);
            await handleLocationChange();

            $('#cbo_store_name').val(data.store_id);
            await handleStoreChange();

            $('#cbo_floor_name').val(data.floor_id);
            await handleFloorChange(data.floor_id);

            $('#cbo_room_no').val(data.room_id);
            await handleRoomChange(data.room_id);

            $('#cbo_rack_no').val(data.rack_id);
            await handleRackChange(data.rack_id);

            $('#cbo_shelf_no').val(data.shelf_id).trigger('change');
            
            document.getElementById('txt_bin_no').value = data.bin_no;
            document.getElementById('update_id').value = data.id;

            set_button_status(1, permission, 'fnc_lib_rack', 1);
            release_freezing();
        } catch (error) {
            console.error('Error:', error);
            release_freezing();
        }
    }

    async function handleCompanyChange() {
        try {
            await load_drop_down_v2('load_drop_down',JSON.stringify({'company_id':document.getElementById('cbo_company_name').value,'onchange':'handleLocationChange()'}), 'location_under_company', 'location_div')
        } catch (error) {
            console.error('Error loading dropdown:', error);
        }
    }

    async function handleLocationChange() {
        try {
            await load_drop_down_v2('load_drop_down',JSON.stringify({'location_id':document.getElementById('cbo_location_name').value,'onchange':'handleStoreChange()'}), 'store_under_location', 'store_div');

        } catch (error) {
            console.error('Error loading dropdown:', error);
        }
    }

    async function handleStoreChange() {
        try {
            await load_drop_down_v2('load_drop_down', JSON.stringify({'store_id':document.getElementById('cbo_store_name').value,'onchange':'handleFloorChange()'}), 'floor_under_store', 'floor_div');
        } catch (error) {
            console.error('Error loading dropdown:', error);
        }
    }
    async function handleFloorChange() {
        try {
            await load_drop_down_v2('load_drop_down', JSON.stringify({'floor_id':document.getElementById('cbo_floor_name').value,'onchange':'handleRoomChange()'}), 'room_under_floor', 'room_div');
        } catch (error) {
            console.error('Error loading dropdown:', error);
        }
    }
    async function handleRoomChange() {
        try {
            await load_drop_down_v2('load_drop_down', JSON.stringify({'room_id':document.getElementById('cbo_room_no').value,'onchange':'handleRackChange()'}), 'rack_under_room', 'rack_div');
        } catch (error) {
            console.error('Error loading dropdown:', error);
        }
    }
    async function handleRackChange() {
        try {
            await load_drop_down_v2('load_drop_down', JSON.stringify({'rack_id':document.getElementById('cbo_rack_no').value,'onchange':''}), 'shelf_under_rack', 'shelf_div');
        } catch (error) {
            console.error('Error loading dropdown:', error);
        }
    }

    setFilterGrid("list_view", -1);
</script>
@endsection
