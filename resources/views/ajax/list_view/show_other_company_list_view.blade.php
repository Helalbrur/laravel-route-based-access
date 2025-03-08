<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th width="3%">Sl</th>
            
            <th width="50%">Company Name</th>
            <th >Short Name</th>
            
        </tr>
    </thead>
    <tbody id="list_view">
        <?php
        $sl = 1;
        $companies = App\Models\OtherCompany::get();

        ?>
        @foreach($companies as $company)
        <tr id="tr_{{$sl}}" onclick="load_php_data_to_form('{{$company->id}}')" style="cursor:pointer">
            <td>{{$sl++}}</td>
            <td>{{$company->name}}</td>
            <td>{{$company->short_name}}</td>
            
        </tr>
        @endforeach
    </tbody>
</table>