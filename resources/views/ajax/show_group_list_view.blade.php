<table class="table table-bordered table-striped" >
    <thead>
        <tr>
            <th width="10%">Sl</th>
            <th width="25%">Group Name</th>
            <th width="15%">Short Name</th>
            <th width="10%">Contact No</th>
            <th width="10%">Address</th>
            <th >Image</th>
            
        </tr>
    </thead>
    <tbody id="list_view">
        <?php
            $sl = 1;
            $groups = DB::table('lib_group as a')
                            ->leftJoin('image_uploads as b', function ($join) {
                                $join->on('a.id', '=', 'b.sys_no')
                                    ->where('b.page_name', '=', 'group_profile')
                                    ->where('b.file_type', '=', 1);
                            })
                            ->whereNull('a.deleted_at')
                            ->select('a.*', 'b.file_name','b.file_type')
                            ->get();
        ?>
        @foreach($groups as $group)
            <tr id="tr_{{$sl}}" onclick="load_php_data_to_form('{{$group->id}}')" style="cursor:pointer" >
                <td>{{$sl++}}</td>
                <td>{{$group->group_name}}</td>
                <td>{{$group->group_short_name}}</td>
                <td>{{$group->contact_no}}</td>
                <td>{{$group->address}}</td>
                <td>
                    @if(!empty($group->file_name) && $group->file_type==1)
                        <a href="{{asset($group->file_name)}}" download><img src="{{asset($group->file_name)}}" height="100" width="100" download></a>
                    @elseif(!empty($group->file_name))
                        <a href="{{asset($group->file_name)}}" download><img src="{{asset('image/download.png')}}" height="45" width="55"></a>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>