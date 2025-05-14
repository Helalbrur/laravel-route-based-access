<?php

    $data = json_decode($param,true);

    $company_id     = $data['company_id'];
    $txt_receive_no  = $data['txt_receive_no'];
    $from_date      = $data['txt_from_date'];
    $to_date        = $data['txt_to_date'];
    
    $query_builder = App\Models\InvReceiveMaster::query();
    if(!empty($company_id))
    {
        $query_builder = $query_builder->where('company_id', $company_id);
    }
    
    if(!empty($txt_receive_no))
    {
        $query_builder = $query_builder->where('sys_number' , 'like', '%'.trim($txt_receive_no).'%');
    }
    
    if(!empty($from_date) && !empty($to_date))
    {
        $query_builder = $query_builder->whereBetween('receive_date', [$from_date, $to_date]);
    }
    
    $receives = $query_builder->get();
    
?>
<table id="list_view" class="table table-striped" style="width: 100%">
    <thead>
        <tr>
            <th>Company</th>
            <th>Receive No</th>
            <th>Receive Date</th>
        </tr>
    </thead>
    <tbody>
        <?php $sl = 1;?>
        @foreach($receives as $receive)
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
                $param = json_encode($receive);
            ?>
            <tr id="tr_{{$receive->id}}" onclick="js_set_value('{{ $param }}' )" style="cursor: pointer;" class="{{ $class }}">
                <td>{{ get_all_company()[$receive->company_id] ?? '' }}</td>
                <td>{{ $receive->sys_number }}</td>
                <td>{{ $receive->receive_date }}</td>
                
            </tr>
        @endforeach
    </tbody>
</table>