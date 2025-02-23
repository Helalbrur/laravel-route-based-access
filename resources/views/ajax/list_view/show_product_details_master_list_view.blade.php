<table class="table table-bordered table-striped" >
    <thead>
        <tr>
            <th width="3%">Sl</th>
            <th width="12%">Generic Name</th>
            <th width="15%">Item Name</th>
            <th width="10%">Item Code</th>
            <th width="12%">Item Category</th>
            <th width="13%">Brand</th>
            <th width="13%">Item Color</th>
            <th>Conversion fac.</th>
        </tr>
    </thead>
    <tbody id="list_view">
        <?php
            $sl = 1;
            $lib_items = DB::table('product_details_master as a')
                    ->leftJoin('lib_generic as b','a.generic_id','=','b.id')
                    ->leftJoin('lib_category as c','a.item_category_id','=','c.id')
                    ->leftJoin('lib_brand as d','a.brand_id','=','d.id')
                    ->leftJoin('lib_color as e','a.color_id','=','e.id')
                    ->select('a.id','a.item_description','a.item_code','a.conversion_fac','b.generic_name','c.category_name','d.name','e.color_name')
                    ->get();
        
        ?>
        @foreach($lib_items as $lib_item)
            <tr id="tr_{{$sl}}" onclick="load_php_data_to_form('{{$lib_item->id}}')" style="cursor:pointer">
                <td>{{$sl++}}</td>
                <td>{{$lib_item->generic_name}}</td>
                <td>{{$lib_item->item_description}}</td>
                <td>{{$lib_item->item_code}}</td>
                <td>{{$lib_item->category_name}}</td>
                <td>{{$lib_item->name}}</td>
                <td>{{$lib_item->color_name}}</td>
                <td>{{$lib_item->conversion_fac}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
<script>
    setFilterGrid("list_view",-1);
</script>