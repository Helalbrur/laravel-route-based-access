<table class="table table-bordered table-striped text-center">
    <thead class="table-secondary">
        <tr>
            <th width="5%">Sl</th>
            <th width="20%">Company Name</th>
            <th width="15%">Location Name</th>
            <th width="15%">Store</th>
            <th width="15%">Floor Name</th>
            <th width="15%">Room No</th>
            <th>Shelf No</th>
        </tr>
    </thead>
    <tbody id="list_view">
        <?php

        use Illuminate\Support\Facades\DB;

        $sl = 1;

        $shelfs = DB::table('lib_floor_room_rack_mst as a')
            ->join('lib_floor_room_rack_dtls as b', 'a.id', 'b.shelf_id')
            ->leftJoin('lib_location as c', 'b.location_id', 'c.id')
            ->leftJoin('lib_store_location as d', 'b.store_id', 'd.id')
            ->leftJoin('lib_company as e', 'a.company_id', 'e.id')
            ->leftJoin('lib_floor as f', 'b.floor_id', 'f.id')
            ->leftJoin('lib_floor_room_rack_mst as room', 'b.room_id', 'room.id')
            ->leftJoin('lib_floor_room_rack_mst as shelf', 'b.shelf_id', 'shelf.id')
            ->select(
                'a.id',
                'd.store_name',
                'e.company_name',
                'c.location_name',
                'f.floor_name',
                'room.floor_room_rack_name as room_no',
                'shelf.floor_room_rack_name as shelf_no'
            )
            ->whereNull('a.deleted_at')
            ->whereNull('b.deleted_at')
            ->get();

        ?>
        @foreach($shelfs as $shelf)
        <tr id="tr_{{$sl}}" onclick="load_php_data_to_form('{{$shelf->id}}')" style="cursor:pointer">
            <td>{{$sl++}}</td>
            <td>{{$shelf->company_name}}</td>
            <td>{{$shelf->location_name}}</td>
            <td>{{$shelf->store_name}}</td>
            <td>{{$shelf->floor_name}}</td>
            <td>{{$shelf->room_no}}</td>
            <td>{{$shelf->shelf_no}}</td>
        </tr>
        @endforeach
    </tbody>
</table>