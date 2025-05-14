<table class="table table-bordered table-striped text-center">
    <thead>
        <tr>
            <th width="10%">Sl</th>
            <th width="45%">Department Name</th>
        </tr>
    </thead>
    <tbody id="list_view">
        <?php
        use Illuminate\Support\Facades\DB;
        $sl = 1;
        $departments = DB::table('lib_department as a')
            ->leftJoin('lib_company as b', 'a.company_id', 'b.id')
            ->whereNull('a.deleted_at')
            ->select('a.id', 'a.department_name', 'b.company_name')
            //->ddRawSql();
            ->get();
        ?>

        @foreach($departments as $department)
        <tr id="tr_{{$sl}}" onclick="load_php_data_to_form('{{$department->id}}')" style="cursor:pointer">
            <td>{{$sl++}}</td>
            <td>{{$department->department_name}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
<script>
    setFilterGrid("list_view",-1);
</script>