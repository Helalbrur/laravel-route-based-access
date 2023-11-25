<table class="table table-bordered table-striped" >
    <thead>
        <tr>
            <th width="3%">Sl</th>
            <th width="12%">Supplier Name</th>
            <th width="15%">Company Name</th>
            <th width="10%">Country Name</th>
            <th width="12%">Email</th>
            <th width="13%">Website</th>
            <th width="13%">Contact No</th>
            <th >Address</th>
        </tr>
    </thead>
    <tbody id="list_view">
        <?php
            $sl = 1;
            $suppliers = App\Models\LibSupplier::get();
        
        ?>
        @foreach($suppliers as $supplier)
            <tr id="tr_{{$sl}}" onclick="load_php_data_to_form('{{$supplier->id}}')" style="cursor:pointer">
                <td>{{$sl++}}</td>
                <td>{{$supplier->supplier_name}}</td>
                <td>
                    <?php $i = 0;?>
                    @foreach($supplier->company as $com)
                        {{$com->company_name}}
                        {{ $i > 0 ? ',' : '' }}
                        <?php $i++;?>
                    @endforeach
                </td>
                <td>{{$supplier->country->country_name ?? ''}}</td>
                <td>{{$supplier->email}}</td>
                <td>{{$supplier->website}}</td>
                <td>{{$supplier->contact_no}}</td>
                <td>{{$supplier->address}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
<script>
    setFilterGrid("list_view",-1);
</script>