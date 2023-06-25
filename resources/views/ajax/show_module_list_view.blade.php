<table class="table-bordered table-striped" >
    <thead>
        <tr>
            <th width="10%">Sl</th>
            <th width="40%">Module Name</th>
            <th width="20%">File Location</th>
            <th width="10%">Sequence</th>
            <th >Visiblity</th>
            
        </tr>
    </thead>
    <tbody id="list_view">
        <?php
            $sl = 1;
            $yes_no = array(1 => "Yes", 2 => "No");
            $mainModules = App\Models\MainModule::get();
        ?>
        @foreach($mainModules as $module)
            <tr id="tr_{{$sl}}" onclick="load_php_data_to_form('{{$module->m_mod_id}}','tools/create_main_module/get_data_by_id')" style="cursor:pointer" >
                <td>{{$sl++}}</td>
                <td>{{$module->main_module}}</td>
                <td>{{$module->file_name}}</td>
                <td>{{$module->mod_slno}}</td>
                <td>{{$yes_no[$module->status]}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
<script>
    setFilterGrid("list_view",-1);
</script>