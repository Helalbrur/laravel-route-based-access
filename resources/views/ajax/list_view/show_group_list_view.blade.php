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
            $images = DB::table('image_uploads as b')
                        ->where('b.page_name', '=', 'group_profile')
                        ->select('b.sys_no', 'b.file_name', 'b.file_type','b.id')
                        ->get();
            $group_images = array();
            foreach($images as $image)
            {
                $group_images[$image->sys_no][$image->id]['file_name'] = $image->file_name;
                $group_images[$image->sys_no][$image->id]['file_type'] = $image->file_type;
            }
            /*
            $groups = DB::table('lib_group as a')
                        ->leftJoin('image_uploads as b', function ($join) {
                            $join->on('a.id', '=', 'b.sys_no')
                                ->where('b.page_name', '=', 'group_profile')
                                ->where('b.file_type', '=', 1);
                        })
                        ->whereNull('a.deleted_at')
                        ->select('a.*', 'b.file_name', 'b.file_type')
                        ->groupBy('a.id','b.file_name', 'b.file_type')
                        ->get();
            */
            $groups = DB::table('lib_group as a')
                        ->whereNull('a.deleted_at')
                        ->select('a.*')
                        ->get();
        ?>

        @foreach($groups as $group)
            <tr id="tr_{{$sl}}" onclick="load_php_data_to_form('{{$group->id}}')" style="cursor:pointer">
                <td>{{$sl++}}</td>
                <td>{{$group->group_name}}</td>
                <td>{{$group->group_short_name}}</td>
                <td>{{$group->contact_no}}</td>
                <td>{{$group->address}}</td>
                <td>
                    @if(isset($group_images[$group->id]) && count($group_images[$group->id]) > 0)
                        @foreach($group_images[$group->id] as $imageUpload)
                            @if(!empty($imageUpload['file_name']) && $imageUpload['file_type'] == 1) 
                                <a href="{{asset($imageUpload['file_name'])}}" download>
                                    <img src="{{asset($imageUpload['file_name'])}}" height="100" width="100" download>
                                </a>
                            @elseif(!empty($imageUpload['file_name']))
                                <a href="{{asset($imageUpload['file_name'])}}" download>
                                    <img src="{{asset('image/download.png')}}" height="45" width="55">
                                </a>
                            @endif
                        @endforeach
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<script>
    setFilterGrid("list_view",-1);
</script>