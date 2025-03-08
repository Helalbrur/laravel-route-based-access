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