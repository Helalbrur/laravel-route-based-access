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
                                            <label for="cbo_product_id" class="col-sm-3 col-form-label fw-bold text-start must_entry_caption">Item Name</label>
                                            <div class="col-sm-8 d-flex align-items-center">
                                                <select name="cbo_product_id" id="cbo_product_id" onchange="handleProductChange()" class="form-control">
                                                    <option value="0">SELECT</option>
                                                    <?php $products = App\Models\ProductDetailsMaster::pluck('item_description', 'id'); ?>
                                                    @foreach($products as $id => $item_description)
                                                    <option value="{{ $id }}">{{ $item_description }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row d-flex justify-content-center">
                                            <label for="txt_supplier" class="col-sm-3 col-form-label fw-bold text-start must_entry_caption">Supplier</label>
                                            <div class="col-sm-8 d-flex align-items-center">
                                                <input type="text" class="form-control" id="txt_supplier" name="txt_supplier" placeholder="Supplier" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row d-flex justify-content-center">
                                            <label for="txt_category" class="col-sm-3 col-form-label fw-bold text-start must_entry_caption">Item Category</label>
                                            <div class="col-sm-8 d-flex align-items-center">
                                                <input type="text" class="form-control" id="txt_category" name="txt_category" placeholder="Category" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row d-flex justify-content-center">
                                            <label for="txt_item_code" class="col-sm-3 col-form-label fw-bold text-start must_entry_caption">Item Code</label>
                                            <div class="col-sm-8 d-flex align-items-center">
                                                <input type="text" class="form-control" id="txt_item_code" name="txt_item_code" placeholder="Item Code" readonly>
                                            </div>
                                        </div>

                                        <div class="form-group row d-flex justify-content-center">
                                            <label for="txt_size" class="col-sm-3 col-form-label fw-bold text-start must_entry_caption">Size</label>
                                            <div class="col-sm-8 d-flex align-items-center">
                                                <input type="text" class="form-control" id="txt_size" name="txt_size" placeholder="Size" readonly>
                                            </div>
                                        </div>

                                        <div class="form-group row d-flex justify-content-center">
                                            <label for="txt_doage" class="col-sm-3 col-form-label fw-bold text-start must_entry_caption">Doage</label>
                                            <div class="col-sm-8 d-flex align-items-center">
                                                <input type="text" class="form-control" id="txt_doage" name="txt_doage" placeholder="Doage" readonly>
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="form-group row d-flex justify-content-center">
                                            <label for="cbo_floor_name" class="col-sm-3 col-form-label fw-bold text-start must_entry_caption">Floor Name</label>
                                            <div class="col-sm-8 d-flex align-items-center" id="floor_div">
                                                <?php $floors = App\Models\LibFloor::get(); ?>
                                                <select name="cbo_floor_name" id="cbo_floor_name" class="form-control" onchange="handleFloorChange()">
                                                    <option value="0">SELECT</option>
                                                    @foreach($floors as $floor)
                                                    <option value="{{$floor->id}}">{{$floor->floor_name}}</option>
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
                                        <div class="form-group row d-flex justify-content-center">
                                            <label for="cbo_bin_no" class="col-sm-3 col-form-label fw-bold text-start must_entry_caption">Bin No</label>
                                            <div class="col-sm-8 d-flex align-items-center" id="bin_div">
                                                <?php 
                                                    $bins = LibFloorRoomRackMst::whereHas('bin_details')->get(); 
                                                ?>
                                                <select name="cbo_bin_no" id="cbo_bin_no" class="form-control">
                                                    <option value="0">SELECT</option>
                                                    @foreach($bins as $bin)
                                                        <option value="{{$bin->id}}">{{$bin->floor_room_rack_name}}</option>
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
                                        <th width="8%">Supplier</th>
                                        <th width="8%">Category</th>
                                        <th width="10%">Item</th>
                                        <th width="8%">Item Code</th>
                                        <th width="8%">Size</th>
                                        <th width="7%">Doage</th>
                                        <th width="10%">Floor Name</th>
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
                                    
                                    $bins = DB::table('product_room_rack_selves as a')
                                        ->leftJoin('product_details_master as p', 'a.product_id', 'p.id')
                                        ->leftJoin('lib_floor_room_rack_mst as floor', 'a.floor_id', 'floor.id')
                                        ->leftJoin('lib_floor_room_rack_mst as room', 'a.room_id', 'room.id')
                                        ->leftJoin('lib_floor_room_rack_mst as rack', 'a.rack_id', 'rack.id')
                                        ->leftJoin('lib_floor_room_rack_mst as shelf', 'a.shelf_id', 'shelf.id')
                                        ->leftJoin('lib_floor_room_rack_mst as bin', 'a.bin_id', 'bin.id')
                                        ->select(
                                            'a.id',
                                            'a.product_id',
                                            'p.item_description',
                                            'p.item_code',
                                            'p.size_id',
                                            'p.dosage_form',
                                            'p.supplier_id',
                                            'p.item_category_id',
                                            'floor.floor_room_rack_name as floor_no',
                                            'room.floor_room_rack_name as room_no',
                                            'rack.floor_room_rack_name as rack_no',
                                            'shelf.floor_room_rack_name as shelf_no',
                                            'bin.floor_room_rack_name as bin_no'
                                        )
                                        ->whereNull('a.deleted_at')
                                        ->get();
                                    
                                    ?>
                                    @foreach($bins as $bin)
                                    <tr id="tr_{{$sl}}" onclick="load_php_data_to_form('{{$bin->id}}')" style="cursor:pointer">
                                        <td>{{$sl++}}</td>
                                        <td>{{get_all_supplier()[$bin->supplier_id] ?? ''}}</td>
                                        <td>{{get_item_category()[$bin->item_category_id] ?? ''}}</td>
                                        <td>{{$bin->item_description}}</td>
                                        <td>{{$bin->item_code}}</td>
                                        <td>{{get_all_size()[$bin->size_id] ?? ''}}</td>
                                        <td>{{$bin->dosage_form}}</td>
                                        <td>{{$bin->floor_no}}</td>
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
        if (form_validation('cbo_product_id*cbo_floor_name*cbo_room_no*cbo_rack_no*cbo_shelf_no*cbo_bin_no','Product*Room No*Rack No*Shelf No*Bin No')==false)
        {
            return;
        }
        else
        {
            var formData = get_form_data('cbo_product_id,cbo_floor_name,cbo_room_no,cbo_rack_no,cbo_shelf_no,cbo_bin_no,update_id');
            var method ="POST";
            var param = "";
            if(operation == 1 || operation == 2)
            {
                param = `/${document.getElementById('update_id').value}`;
                if(operation == 1) formData.append('_method', 'PUT');
                else formData.append('_method', 'DELETE');
            }
            formData.append('_token', '{{csrf_token()}}');
            var url = `/lib/inventory/product_room_rack${param}`;
            var requestData = {
                method: method,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                body: formData
            };

            save_update_delete(operation,url,requestData,'id','show_product_room_rack_list_view','list_view_div','libBin_1');
        }
    }

    async function load_php_data_to_form(bin_id) {
        try {
            freeze_window(3);
            reset_form('libBin_1', '', '', 1);
            const response = await fetch(`/product_room_rack_details/${bin_id}`);
            if (!response.ok) throw new Error('Failed to fetch data');
            const data = await response.json();
            console.log(data);

            $('#cbo_product_id').val(data.product_id);
            await handleProductChange();

            
            $('#cbo_floor_name').val(data.floor_id);
            await handleFloorChange(data.floor_id);

            $('#cbo_room_no').val(data.room_id);
            await handleRoomChange(data.room_id);

            $('#cbo_rack_no').val(data.rack_id);
            await handleRackChange(data.rack_id);

            $('#cbo_shelf_no').val(data.shelf_id);
            await handleShelfChange(data.shelf_id);

            //$('#cbo_bin_no').val(data.bin_id);
            $('#cbo_bin_no').val(data.bin_id).trigger('change');
        
            document.getElementById('update_id').value = data.id;

            set_button_status(1, permission, 'fnc_lib_rack', 1);
            release_freezing();
        } catch (error) {
            console.error('Error:', error);
            release_freezing();
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
            await load_drop_down_v2('load_drop_down', JSON.stringify({'rack_id':document.getElementById('cbo_rack_no').value,'onchange':'handleShelfChange()'}), 'shelf_under_rack', 'shelf_div');
        } catch (error) {
            console.error('Error loading dropdown:', error);
        }
    }

     async function handleShelfChange() {
        try {
            var container = "bin_div";
            await load_drop_down_v2('load_drop_down', JSON.stringify({'shelf_id':document.getElementById('cbo_shelf_no').value,'onchange':'','row_id':''}), 'bin_under_shelf', container);
        } catch (error) {
            console.error('Error loading dropdown:', error);
        }
    }

    async function handleProductChange(params){
        try {
            fetch(`/get_product_details/${document.getElementById('cbo_product_id').value}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('txt_item_code').value = data.item_code ?? '';
                document.getElementById('txt_size').value = data.size ?? '';
                document.getElementById('txt_doage').value = data.doage ?? '';
                document.getElementById('txt_supplier').value = data.supplier ?? '';
                document.getElementById('txt_category').value = data.category ?? '';
            });
        } catch (error) {
            
        }
    }

    setFilterGrid("list_view", -1);
</script>
@endsection
