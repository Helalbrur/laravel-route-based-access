<table class="table table-bordered table-striped" >
    <thead>
        <tr>
            <th width="10%">Sl</th>
            <th width="20%">Category Name</th>
            <th width="25%">Item Group Name</th>
            <th width="25%">Sub Group Name</th>
            <th >Sub Group Code</th>
            
        </tr>
    </thead>
    <tbody id="list_view">
        <?php
            $sl = 1;
            $item_sub_groups = DB::table('lib_item_sub_group as a')
                        ->leftJoin('lib_category as b','a.item_category_id','b.id')
                        ->leftJoin('lib_item_group as c','a.item_group_id','c.id')
                        ->whereNull('a.deleted_at')
                        ->select('a.id','a.sub_group_name','a.sub_group_code','c.item_name','b.category_name')
                        ->get();
        ?>

        @foreach($item_sub_groups as $sub_group)
            <tr id="tr_{{$sl}}" onclick="load_php_data_to_form('{{$sub_group->id}}')" style="cursor:pointer">
                <td>{{$sl++}}</td>
                <td>{{$sub_group->category_name}}</td>
                <td>{{$sub_group->item_name}}</td>
                <td>{{$sub_group->sub_group_name}}</td>
                <td>{{$sub_group->sub_group_code}}</td>
            </tr>
        @endforeach
    </tbody>
</table>