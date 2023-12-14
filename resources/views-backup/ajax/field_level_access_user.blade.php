@extends('layouts.popup')
@section('content')
<div >
    <input type="hidden" id="user_id" >
    <input type="hidden" id="user_name" >
    <table class="table table-striped table-bordered rpt_table bg-info" style="width:450px;margin-bottom:0px;padding-bottom:0px;">
        <tbody>
            <tr>
                <th width="10%">Sl</th>
                <th>User Name</th>

            </tr>
        </tbody>
    </table>
        <div style="max-height: 350px;overflow-y: scroll;width:468px">
            <table class="table table-striped table-bordered" style="width:450px">
                <tbody  id="list_view">
                    <?php
                        $users = App\Models\User::get();                          
                        $sl = 1;
                    ?>
                    @foreach($users as $user)
                        <tr  style="cursor:pointer" onclick="set_entry_form('{{$user->id}}','{{$user->name}}')">
                            <td width="10%">{{$sl++}}</td>
                            <td>{{$user->name}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </table>
</div>

@endsection

@section('script')
<script>
    function set_entry_form(id,name) 
    {
        $("#user_id").val(id);
        $("#user_name").val(name);
        parent.emailwindow.hide();
    }
    setFilterGrid("list_view",-1);
</script>
@endsection