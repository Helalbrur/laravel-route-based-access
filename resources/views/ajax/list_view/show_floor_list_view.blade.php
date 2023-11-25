<table class="table table-bordered table-striped" >
    <thead>
        <tr>
            <th width="10%">Sl</th>
            <th width="20%">Floor Name</th>
            <th width="25%">Company Name</th>
            <th width="25%">Location Name</th>
            <th >Store</th>
            
        </tr>
    </thead>
    <tbody id="list_view">
        <?php
            $sl = 1;
            $floors = DB::table('lib_floor as a')
                        ->leftJoin('lib_company as b','a.company_id','b.id')
                        ->leftJoin('lib_location as c','a.location_id','c.id')
                        ->leftJoin('lib_store_location as d','a.store_id','d.id')
                        ->select('a.id','d.store_name','b.company_name','c.location_name','a.floor_name')
                        ->get();
        ?>

        @foreach($floors as $floor)
            <tr id="tr_{{$sl}}" onclick="load_php_data_to_form('{{$floor->id}}')" style="cursor:pointer">
                <td>{{$sl++}}</td>
                <td>{{$floor->floor_name}}</td>
                <td>{{$floor->company_name}}</td>
                <td>{{$floor->location_name}}</td>
                <td>{{$floor->store_name}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
<script>
    setFilterGrid("list_view",-1);
</script>