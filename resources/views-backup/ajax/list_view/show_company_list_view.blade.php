<table class="table table-bordered table-striped" >
    <thead>
        <tr>
            <th width="3%">Sl</th>
            <th width="12%">Group Name</th>
            <th width="15%">Company Name</th>
            <th width="10%">Short Name</th>
            <th width="12%">Email</th>
            <th width="13%">Website</th>
            <th width="13%">Contact No</th>
            <th >Address</th>
        </tr>
    </thead>
    <tbody id="list_view">
        <?php
            $sl = 1;
            $companies = App\Models\Company::get();
        
        ?>
        @foreach($companies as $company)
            <tr id="tr_{{$sl}}" onclick="load_php_data_to_form('{{$company->id}}')" style="cursor:pointer">
                <td>{{$sl++}}</td>
                <td>{{$company->company_name}}</td>
                <td>{{$company->group->group_name ?? ''}}</td>
                <td>{{$company->company_short_name}}</td>
                <td>{{$company->email}}</td>
                <td>{{$company->website}}</td>
                <td>{{$company->contact_no}}</td>
                <td>{{$company->address}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
<script>
    setFilterGrid("list_view",-1);
</script>