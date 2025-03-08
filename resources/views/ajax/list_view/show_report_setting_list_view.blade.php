<table class="table table-bordered table-striped" >
    <thead>
        <tr>
            <th width="7%">Sl</th>
            <th width="15%">Company Name</th>
            <th width="10%">Module Name</th>
            <th width="20%">Report Name</th>
            <th width="25%">Format Name</th>
            <th >User Name</th>
            
        </tr>
    </thead>
    <tbody id="list_view">
        <?php
             $settings = DB::table('lib_report_template as a')
             ->leftJoin('lib_company as b','a.company_id','b.id')
             ->leftJoin('main_module as c','a.module_id','c.m_mod_id');
            $sl = 1;
            $param = str_replace("'","",$param);
            if(!empty($param))
            {
                $param = explode("_",$param);
                if(count($param) > 0)
                {
                    $company_id = $param[0];
                    $module_id = $param[1];
                    $report_id = $param[2];
                    if(!empty($company_id))
                    {
                        $settings = $settings->where('a.company_id',$company_id);
                    }
                    if(!empty($module_id))
                    {
                        $settings = $settings->where('a.module_id',$module_id);
                    }
                    if(!empty($report_id))
                    {
                        $settings = $settings->where('a.report_id',$report_id);
                    }
                }
            }
            $settings = $settings->select('a.id','a.user_id','a.report_id','a.format_id','b.company_name','c.main_module')
                        ->get();
            $report_format = report_format();
            $user_names = user_names();
            $report_name = report_name();
        ?>

        @foreach($settings as $setting)
            <tr id="tr_{{$sl}}" onclick="load_php_data_to_form('{{$setting->id}}')" style="cursor:pointer">
                <td>{{$sl++}}</td>
                <td>{{$setting->company_name}}</td>
                <td>{{$setting->main_module}}</td>
                <td>{{$report_name[$setting->report_id]}}</td>
                <td>
                    <?php
                    $format_ids = explode(",",$setting->format_id);
                    $sl_f = 0;
                    foreach($format_ids as $format_id)
                    {
                        if($sl_f > 0) echo ",";
                        echo  $report_format[$format_id];
                        $sl_f++;
                    }
                    ?>
                </td>
                <td>
                    <?php
                    $user_ids = explode(",",$setting->user_id);
                    $sl_f = 0;
                    foreach($user_ids as $user_id)
                    {
                        if($sl_f > 0) echo ",";
                        echo  $user_names[$user_id];
                        $sl_f++;
                    }
                    ?>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<script>
    setFilterGrid("list_view",-1);
    release_freezing();
</script>