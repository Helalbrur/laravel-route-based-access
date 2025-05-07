<?php

    $data = json_decode($param,true);

    $company_id     = $data['company_id'];
    $txt_issue_no   = $data['txt_issue_no'];
    $from_date      = $data['txt_from_date'];
    $to_date        = $data['txt_to_date'];
    
    $query_builder = App\Models\InvIssueMaster::query();
    dd($query_builder->toSql());
    if(!empty($company_id))
    {
        $query_builder = $query_builder->where('company_id', $company_id);
    }
    
    if(!empty($txt_issue_no))
    {
        $query_builder = $query_builder->where('sys_number' , 'like', '%'.trim($txt_issue_no).'%');
    }
    
    if(!empty($from_date) && !empty($to_date))
    {
        $query_builder = $query_builder->whereBetween('date', [$from_date, $to_date]);
    }
    
    $issue = $query_builder->get();
    
?>
<table id="list_view" class="table table-striped" style="width: 100%">
    <thead>
        <tr>
            <th>Company</th>
            <th>Issue No</th>
            <th>Issue Date</th>
        </tr>
    </thead>
    <tbody>
        <?php $sl = 1;?>
        @foreach($issuess as $issue)
            <?php 
                if($sl % 2 == 0)
                {
                    $class = 'even';
                }
                else
                {
                    $class = 'odd';
                }
                $sl++;
                $param = json_encode($issue);
            ?>
            <tr id="tr_{{$issue->id}}" onclick="js_set_value('{{ $param }}' )" style="cursor: pointer;" class="{{ $class }}">
                <td>{{ get_all_company()[$issue->company_id] ?? '' }}</td>
                <td>{{ $issue->sys_number }}</td>
                <td>{{ $issue->date }}</td>
                
            </tr>
        @endforeach
    </tbody>
</table>