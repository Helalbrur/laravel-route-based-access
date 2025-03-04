<table class="table table-bordered table-striped text-center">
    <thead>
        <tr>
            <th width="10%">Sl</th>
            <th width="45%">Brand Name</th>
        </tr>
    </thead>
    <tbody id="list_view">
        <?php
        use Illuminate\Support\Facades\DB;
        $sl = 1;
        $brands = DB::table('lib_brand as a')
            ->leftJoin('lib_buyer as b', 'a.buyer_id', 'b.id')
            ->whereNull('a.deleted_at')
            ->select('a.id', 'a.brand_name', 'b.buyer_name')
            //->ddRawSql();
            ->get();
        ?>

        @foreach($brands as $brand)
        <tr id="tr_{{$sl}}" onclick="load_php_data_to_form('{{$brand->id}}')" style="cursor:pointer">
            <td>{{$sl++}}</td>
            <td>{{$brand->brand_name}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
<script>
    setFilterGrid("list_view",-1);
</script>