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
            $lib_items = App\Models\ProductDetailsMaster::get();
        
        ?>
        @foreach($lib_items as $lib_item)
        <tr id="tr_{{$sl}}" onclick="load_php_data_to_form('{{$lib_item->id}}')" style="cursor:pointer">
            <td>{{$sl++}}</td>
            <td>{{$lib_item->generic_id}}</td>
            <td>{{$lib_item->item_description}}</td>
            <td>{{$lib_item->item_code}}</td>
            <td>{{$lib_item->item_category_id}}</td>
            <td>{{$lib_item->brand_id}}</td>
            <td>{{$lib_item->color_id}}</td>
            <td>{{$lib_item->conversion_fac}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
<script>
    setFilterGrid("list_view",-1);
</script>