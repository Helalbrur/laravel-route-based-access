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