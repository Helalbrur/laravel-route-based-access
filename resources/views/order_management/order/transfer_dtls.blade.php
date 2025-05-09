{{-- Transfer From Card --}}
<input type="hidden" name="hidden_trans_from_id" id="hidden_trans_from_id" value="{{$transferFrom->id}}">
<div class="col-md-6">
    <div class="card h-100" style="background-color: rgb(241, 241, 241);">
        <div class="card-header fw-bold" style="background-color: rgb(226, 226, 226);">Transfer From</div>
        <div class="card-body">

            <div class="form-group row">
                <label for="cbo_location_from" class="col-sm-4 col-form-label">Location</label>
                <div class="col-sm-8 d-flex align-items-center" id="location_div_from">
                    <select name="cbo_location_from" id="cbo_location_from" class="form-control w-100" onchange="handle_location_from_change()">
                        <option value="0">SELECT</option>
                        @foreach(App\Models\LibLocation::pluck('location_name', 'id') as $id => $location_name)
                        <option value="{{ $id }}" {{ (isset($transferFrom) && $transferFrom->location_id == $id) ? 'selected' : '' }}>
                            {{ $location_name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="cbo_store_from" class="col-sm-4 col-form-label">Store</label>
                <div class="col-sm-8 d-flex align-items-center" id="store_div_from" title="{{$transferFrom->store_id}}">
                    <select name="cbo_store_from" id="cbo_store_from" class="form-control w-100" onchange="handle_store_from_change()">
                        <option value="0">SELECT</option>
                        @foreach(App\Models\LibStoreLocation::where('location_id', $transferFrom->location_id)->get() as $store)
                        <option value="{{ $store->id }}" {{ (isset($transferFrom) && $transferFrom->store_id == $store->id) ? 'selected' : '' }}>
                            {{ $store->store_name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="cbo_floor_name_from" class="col-sm-4 col-form-label">Floor</label>
                <div class="col-sm-8 d-flex align-items-center" id="floor_div_from">
                    <select name="cbo_floor_name_from" id="cbo_floor_name_from" class="form-control w-100" onchange="handle_floor_from_change()">
                        <option value="0">SELECT</option>
                        @foreach(App\Models\LibFloor::where('store_id', $transferFrom->store_id)->get() as $floor)
                        <option value="{{ $floor->id }}" {{ (isset($transferFrom) && $transferFrom->floor_id == $floor->id) ? 'selected' : '' }}>
                            {{ $floor->floor_name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="cbo_room_no_from" class="col-sm-4 col-form-label">Room</label>
                <div class="col-sm-8 d-flex align-items-center" id="room_div_from">
                    <select name="cbo_room_no_from" id="cbo_room_no_from" class="form-control w-100" onchange="handle_room_from_change()">
                        <option value="0">SELECT</option>
                        @foreach(\App\Models\LibFloorRoomRackMst::whereHas('room_details', function($query) use ($transferFrom) {
                        $query->where('floor_id', $transferFrom->floor_id);
                        })->get() as $room)
                        <option value="{{ $room->id }}" {{ (isset($transferFrom) && $transferFrom->room_id == $room->id) ? 'selected' : '' }}>
                            {{ $room->floor_room_rack_name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="cbo_rack_no_from" class="col-sm-4 col-form-label">Rack</label>
                <div class="col-sm-8 d-flex align-items-center" id="rack_div_from">
                    <select name="cbo_rack_no_from" id="cbo_rack_no_from" class="form-control w-100" onchange="handle_rack_from_change()">
                        <option value="0">SELECT</option>
                        @foreach(\App\Models\LibFloorRoomRackMst::whereHas('rack_details', function($query) use ($transferFrom) {
                        $query->where('room_id', $transferFrom->room_id);
                        })->get() as $rack)
                        <option value="{{ $rack->id }}" {{ (isset($transferFrom) && $transferFrom->room_rack_id == $rack->id) ? 'selected' : '' }}>
                            {{ $rack->floor_room_rack_name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="cbo_shelf_no_from" class="col-sm-4 col-form-label">Shelf</label>
                <div class="col-sm-8 d-flex align-items-center" id="shelf_div_from">
                    <select name="cbo_shelf_no_from" id="cbo_shelf_no_from" class="form-control w-100" onchange="handle_shelf_from_change()">
                        <option value="0">SELECT</option>
                        @foreach(\App\Models\LibFloorRoomRackMst::whereHas('shelf_details', function($query) use ($transferFrom) {
                        $query->where('rack_id', $transferFrom->room_rack_id);
                        })->get() as $shelf)
                        <option value="{{ $shelf->id }}" {{ (isset($transferFrom) && $transferFrom->room_self_id == $shelf->id) ? 'selected' : '' }}>
                            {{ $shelf->floor_room_rack_name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label for="cbo_bin_no_from" class="col-sm-4 col-form-label">Bin</label>
                <div class="col-sm-8 d-flex align-items-center" id="bin_div_from">
                    <select name="cbo_bin_no_from" id="cbo_bin_no_from" class="form-control w-100">
                        <option value="0">SELECT</option>
                        @foreach(\App\Models\LibFloorRoomRackMst::whereHas('bin_details', function($query) use ($transferFrom) {
                        $query->where('shelf_id', $transferFrom->room_self_id);
                        })->get() as $bin)
                        <option value="{{ $bin->id }}" {{ (isset($transferFrom) && $transferFrom->room_bin_id == $bin->id) ? 'selected' : '' }}>
                            {{ $bin->floor_room_rack_name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- Transfer To Card --}}
<input type="hidden" name="hidden_trans_to_id" id="hidden_trans_to_id"  value="{{$transferTo->id}}">
<div class="col-md-6">
    <div class="card h-100" style="background-color: rgb(241, 241, 241);">
        <div class="card-header fw-bold" style="background-color: rgb(226, 226, 226);">Transfer To</div>
        <div class="card-body">

            <div class="form-group row">
                <label for="cbo_location_to" class="col-sm-4 col-form-label">Location</label>
                <div class="col-sm-8 d-flex align-items-center" id="location_div_to">
                    <select name="cbo_location_to" id="cbo_location_to" class="form-control w-100" onchange="handle_location_to_change()">
                        <option value="0">SELECT</option>
                        @foreach(App\Models\LibLocation::pluck('location_name', 'id') as $id => $location_name)
                        <option value="{{ $id }}" {{ (isset($transferTo) && $transferTo->location_id == $id) ? 'selected' : '' }}>
                            {{ $location_name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="cbo_store_to" class="col-sm-4 col-form-label">Store</label>
                <div class="col-sm-8 d-flex align-items-center" id="store_div_to">
                    <select name="cbo_store_to" id="cbo_store_to" class="form-control w-100" onchange="handle_store_to_change()">
                        <option value="0">SELECT</option>
                        @foreach(App\Models\LibStoreLocation::where('location_id', $transferTo->location_id)->get() as $store)
                        <option value="{{ $store->id }}" {{ (isset($transferTo) && $transferTo->store_id == $store->id) ? 'selected' : '' }}>
                            {{ $store->store_name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="cbo_floor_name_to" class="col-sm-4 col-form-label">Floor</label>
                <div class="col-sm-8 d-flex align-items-center" id="floor_div_to">
                    <select name="cbo_floor_name_to" id="cbo_floor_name_to" class="form-control w-100" onchange="handle_floor_to_change()">
                        <option value="0">SELECT</option>
                        @foreach(App\Models\LibFloor::where('store_id', $transferTo->store_id)->get() as $floor)
                        <option value="{{ $floor->id }}" {{ (isset($transferTo) && $transferTo->floor_id == $floor->id) ? 'selected' : '' }}>
                            {{ $floor->floor_name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="cbo_room_no_to" class="col-sm-4 col-form-label">Room</label>
                <div class="col-sm-8 d-flex align-items-center" id="room_div_to">
                    <select name="cbo_room_no_to" id="cbo_room_no_to" class="form-control w-100" onchange="handle_room_to_change()">
                        <option value="0">SELECT</option>
                        @foreach(\App\Models\LibFloorRoomRackMst::whereHas('room_details', function($query) use ($transferTo) {
                        $query->when(isset($transferTo->floor_id), function($query) use ($transferTo) {
                        $query->where('floor_id', $transferTo->floor_id);
                        });
                        })->get() as $room)
                        <option value="{{ $room->id }}" {{ (isset($transferTo) && $transferTo->room_id == $room->id) ? 'selected' : '' }}>
                            {{ $room->floor_room_rack_name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label for="cbo_rack_no_to" class="col-sm-4 col-form-label">Rack</label>
                <div class="col-sm-8 d-flex align-items-center" id="rack_div_to">
                    <select name="cbo_rack_no_to" id="cbo_rack_no_to" class="form-control w-100" onchange="handle_rack_to_change()">
                        <option value="0">SELECT</option>
                        @foreach(\App\Models\LibFloorRoomRackMst::whereHas('rack_details', function($query) use ($transferTo) {
                        $query->when(isset($transferTo->room_id), function($query) use ($transferTo) {
                        $query->where('room_id', $transferTo->room_id);
                        });
                        })->get() as $rack)
                        <option value="{{ $rack->id }}" {{ (isset($transferTo) && $transferTo->room_rack_id == $rack->id) ? 'selected' : '' }}>
                            {{ $rack->floor_room_rack_name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label for="cbo_shelf_no_to" class="col-sm-4 col-form-label">Shelf</label>
                <div class="col-sm-8 d-flex align-items-center" id="shelf_div_to">
                    <select name="cbo_shelf_no_to" id="cbo_shelf_no_to" class="form-control w-100" onchange="handle_shelf_to_change()">
                        <option value="0">SELECT</option>
                        @foreach(\App\Models\LibFloorRoomRackMst::whereHas('shelf_details', function($query) use ($transferTo) {
                        $query->when(isset($transferTo->room_rack_id), function($query) use ($transferTo) {
                        $query->where('rack_id', $transferTo->room_rack_id);
                        });
                        })->get() as $shelf)
                        <option value="{{ $shelf->id }}" {{ (isset($transferTo) && $transferTo->room_self_id == $shelf->id) ? 'selected' : '' }}>
                            {{ $shelf->floor_room_rack_name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label for="cbo_bin_no_to" class="col-sm-4 col-form-label">Bin</label>
                <div class="col-sm-8 d-flex align-items-center" id="bin_div_to">
                    <select name="cbo_bin_no_to" id="cbo_bin_no_to" class="form-control w-100">
                        <option value="0">SELECT</option>
                        @foreach(\App\Models\LibFloorRoomRackMst::whereHas('bin_details', function($query) use ($transferTo) {
                        $query->when(isset($transferTo->room_self_id), function($query) use ($transferTo) {
                        $query->where('shelf_id', $transferTo->room_self_id);
                        });
                        })->get() as $bin)
                        <option value="{{ $bin->id }}" {{ (isset($transferTo) && $transferTo->room_bin_id == $bin->id) ? 'selected' : '' }}>
                            {{ $bin->floor_room_rack_name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

        </div>
    </div>
</div>