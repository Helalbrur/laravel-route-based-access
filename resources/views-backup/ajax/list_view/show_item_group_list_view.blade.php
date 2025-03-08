<table class="table table-bordered table-striped" >
    <thead>
        <tr>
            <th width="10%">Sl</th>
            <th width="25%">Category Name</th>
            <th width="35%">Item Group Name</th>
            <th >Item Group Code</th>
            
        </tr>
    </thead>
    <tbody id="list_view">
        <?php
            $sl = 1;
            $item_groups = DB::table('lib_item_group as a')
                        ->leftJoin('lib_category as b','a.item_category_id','b.id')
                        ->whereNull('a.deleted_at')
                        ->select('a.id','a.item_name','a.item_group_code','b.category_name')
                        ->get();
        ?>

        @foreach($item_groups as $group)
            <tr id="tr_{{$sl}}" onclick="load_php_data_to_form('{{$group->id}}')" style="cursor:pointer">
                <td>{{$sl++}}</td>
                <td>{{$group->category_name}}</td>
                <td>{{$group->item_name}}</td>
                <td>{{$group->item_group_code}}</td>
            </tr>
        @endforeach
    </tbody>
</table>