<table class="table table-bordered table-striped" >
    <thead>
        <tr>
            <th width="10%">Sl</th>
            <th >Country Name</th>
            
        </tr>
    </thead>
    <tbody id="list_view">
        <?php
            $sl = 1;
            
            
            $countries = DB::table('lib_country as a')
                        ->whereNull('a.deleted_at')
                        ->select('a.*')
                        ->get();
        ?>

        @foreach($countries as $country)
            <tr id="tr_{{$sl}}" onclick="load_php_data_to_form('{{$country->id}}')" style="cursor:pointer">
                <td>{{$sl++}}</td>
                <td>{{$country->country_name}}</td>
            </tr>
        @endforeach
    </tbody>
</table>