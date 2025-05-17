<table class="table table-bordered table-striped text-center">
    <thead class="table-secondary">
        <tr>
            <th width="3%">Sl</th>
            <th width="12%">Supplier Name</th>
            <th width="10%">Company Name</th>
            <th width="8%">Country Name</th>
            <th width="8%">Email</th>
            <th width="8%">Website</th>
            <th width="8%">Contact No</th>
            <th width="10%">Supplier Company</th>
            <th width="10%">Address</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody id="list_view">
        <?php
            $sl = 1;
            $suppliers = App\Models\LibSupplier::withTrashed()->get();
        ?>
        @foreach($suppliers as $supplier)
            <tr id="tr_{{ $sl }}" onclick="load_php_data_to_form('{{ $supplier->id }}')" style="cursor:pointer">
                <td>{{ $sl++ }}</td>
                <td>{{ $supplier->supplier_name }}</td>
                <td>
                    <?php $i = 0; ?>
                    @foreach($supplier->company as $com)
                        {{ $com->company_name }}
                        {{ $i > 0 ? ',' : '' }}
                        <?php $i++; ?>
                    @endforeach
                </td>
                <td>{{ $supplier->country->country_name ?? '' }}</td>
                <td>{{ $supplier->email }}</td>
                <td>{{ $supplier->web_site }}</td>
                <td>{{ $supplier->contact_no }}</td>
                <td>{{ $supplier->other_company->name ?? '' }}</td>
                <td>{{ $supplier->address }}</td>
                <td>{{ $supplier->deleted_at ? 'Inactive' : 'Active' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
<script>
    setFilterGrid("list_view",-1);
</script>