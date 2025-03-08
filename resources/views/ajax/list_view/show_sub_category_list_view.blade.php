<table class="table table-bordered table-striped" >
    <thead>
        <tr>
            <th width="10%">Sl</th>
            <th width="30%">Category Name</th>
            <th width="25%">Sub Category Name</th>
        </tr>
    </thead>
    <tbody id="list_view">
        <?php
                $sl = 1;
                $item_sub_category = DB::table('lib_item_sub_category as a')
                                    ->leftJoin('lib_category as b','a.item_category_id','b.id')
                                    ->whereNull('a.deleted_at')
                                    ->select('a.id','a.sub_category_name','b.category_name')
                                    ->get();
                
        ?>

        @foreach($item_sub_category as $sub_category)
            <tr id="tr_{{$sl}}" onclick="load_php_data_to_form('{{$sub_category->id}}')" style="cursor:pointer">
                <td>{{$sl++}}</td>
                <td>{{$sub_category->category_name}}</td>
                <td>{{$sub_category->sub_category_name}}</td>
            </tr>
        @endforeach
    </tbody>
</table>