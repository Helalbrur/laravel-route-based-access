<table class="table table-bordered table-striped" >
    <thead>
        <tr>
            <th width="10%">Sl</th>
            <th >Uom Name</th>
            
        </tr>
    </thead>
    <tbody id="list_view">
        <?php
            $sl = 1;
            $uoms = DB::table('lib_uom as a')
                        ->whereNull('a.deleted_at')
                        ->select('a.*')
                        ->get();
        ?>

        @foreach($uoms as $uom)
            <tr id="tr_{{$sl}}" onclick="load_php_data_to_form('{{$uom->id}}')" style="cursor:pointer">
                <td>{{$sl++}}</td>
                <td>{{$uom->uom_name}}</td>
            </tr>
        @endforeach
    </tbody>
</table>