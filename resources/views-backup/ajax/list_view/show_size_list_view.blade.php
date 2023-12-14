<table class="table table-bordered table-striped" >
    <thead>
        <tr>
            <th width="10%">Sl</th>
            <th >Size Name</th>
            
        </tr>
    </thead>
    <tbody id="list_view">
        <?php
            $sl = 1;
            
            
            $sizes = DB::table('lib_size as a')
                        ->whereNull('a.deleted_at')
                        ->select('a.*')
                        ->get();
        ?>

        @foreach($sizes as $size)
            <tr id="tr_{{$sl}}" onclick="load_php_data_to_form('{{$size->id}}')" style="cursor:pointer">
                <td>{{$sl++}}</td>
                <td>{{$size->size_name}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
<script>
    setFilterGrid("list_view",-1);
</script>