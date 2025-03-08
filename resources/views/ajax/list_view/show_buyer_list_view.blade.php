<table class="table table-bordered table-striped" >
    <thead>
        <tr>
            <th width="3%">Sl</th>
            <th width="12%">Buyer Name</th>
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
            $buyers = App\Models\LibBuyer::get();
        ?>
        @foreach($buyers as $buyer)
            <tr id="tr_{{$sl}}" onclick="load_php_data_to_form('{{$buyer->id}}')" style="cursor:pointer">
                <td>{{$sl++}}</td>
                <td>{{$buyer->buyer_name}}</td>
                <td>
                    <?php $i = 0;?>
                    @foreach($buyer->company as $com)
                        {{$com->company_name}}
                        {{ $i > 0 ? ',' : '' }}
                        <?php $i++;?>
                    @endforeach
                </td>
                <td>{{$buyer->country->country_name ?? ''}}</td>
                <td>{{$buyer->email}}</td>
                <td>{{$buyer->web_site}}</td>
                <td>{{$buyer->contact_no}}</td>
                <td>{{$buyer->address}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
<script>
    setFilterGrid("list_view",-1);
</script>