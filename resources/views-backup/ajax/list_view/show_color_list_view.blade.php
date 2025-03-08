<table class="table table-bordered table-striped" >
    <thead>
        <tr>
            <th width="10%">Sl</th>
            <th >Color Name</th>
            
        </tr>
    </thead>
    <tbody id="list_view">
        <?php
            $sl = 1;
            
            
            $colors = DB::table('lib_color as a')
                        ->whereNull('a.deleted_at')
                        ->select('a.*')
                        ->get();
        ?>

        @foreach($colors as $color)
            <tr id="tr_{{$sl}}" onclick="load_php_data_to_form('{{$color->id}}')" style="cursor:pointer">
                <td>{{$sl++}}</td>
                <td>{{$color->color_name}}</td>
            </tr>
        @endforeach
    </tbody>
</table>