<table class="table table-bordered table-striped" >
    <thead>
        <tr>
            <th width="10%">Sl</th>
            <th width="50%">Category Name</th>
            <th >Short Name</th>
            
        </tr>
    </thead>
    <tbody id="list_view">
        <?php
            $sl = 1;
            $categories = DB::table('lib_category as a')
                        ->whereNull('a.deleted_at')
                        ->select('a.*')
                        ->get();
        ?>

        @foreach($categories as $category)
            <tr id="tr_{{$sl}}" onclick="load_php_data_to_form('{{$category->id}}')" style="cursor:pointer">
                <td>{{$sl++}}</td>
                <td>{{$category->category_name}}</td>
                <td>{{$category->short_name}}</td>
            </tr>
        @endforeach
    </tbody>
</table>