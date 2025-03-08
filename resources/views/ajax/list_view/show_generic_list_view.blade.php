<table class="table table-bordered table-striped" >
    <thead>
        <tr>
            <th width="10%">Sl</th>
            <th >Generic Name</th>
            
        </tr>
    </thead>
    <tbody id="list_view">
        <?php
            $sl = 1;
            $generics = DB::table('lib_generic as a')
                        ->whereNull('a.deleted_at')
                        ->select('a.*')
                        ->get();
        ?>

        @foreach($generics as $generic)
            <tr id="tr_{{$sl}}" onclick="load_php_data_to_form('{{$generic->id}}')" style="cursor:pointer">
                <td>{{$sl++}}</td>
                <td>{{$generic->generic_name}}</td>
            </tr>
        @endforeach
    </tbody>
</table>