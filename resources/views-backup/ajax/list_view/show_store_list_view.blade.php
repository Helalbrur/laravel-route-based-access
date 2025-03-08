<table class="table table-bordered table-striped" >
    <thead>
        <tr>
            <th width="10%">Sl</th>
            <th width="20%">Store Name</th>
            <th width="25%">Company Name</th>
            <th width="25%">Location Name</th>
            <th >Category</th>
            
        </tr>
    </thead>
    <tbody id="list_view">
        <?php
            $sl = 1;
            $stores = DB::table('lib_store_location as a')
                        ->leftJoin('lib_company as b','a.company_id','b.id')
                        ->leftJoin('lib_location as c','a.location_id','c.id')
                        ->whereNull('a.deleted_at')
                        ->select('a.id','a.store_name','b.company_name','c.location_name')
                        ->get();
        ?>

        @foreach($stores as $store)
            <tr id="tr_{{$sl}}" onclick="load_php_data_to_form('{{$store->id}}')" style="cursor:pointer">
                <td>{{$sl++}}</td>
                <td>{{$store->store_name}}</td>
                <td>{{$store->company_name}}</td>
                <td>{{$store->location_name}}</td>
                <td></td>
            </tr>
        @endforeach
    </tbody>
</table>
<script>
    setFilterGrid("list_view",-1);
</script>