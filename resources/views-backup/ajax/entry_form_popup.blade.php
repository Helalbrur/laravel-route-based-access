@extends('layouts.popup')
@section('content')
<div >
    <input type="hidden" id="entry_form_id" >
    <input type="hidden" id="entry_form_name" >
    <table class="table table-striped table-bordered rpt_table bg-info" style="width:450px;margin-bottom:0px;padding-bottom:0px;">
        <tbody>
            <tr>
                <th width="10%">Sl</th>
                <th>Entry form</th>

            </tr>
        </tbody>
    </table>
        <div style="max-height: 350px;overflow-y: scroll;width:468px">
            <table class="table table-striped table-bordered" style="width:450px">
                <tbody  id="list_view">
                    <?php
                        $entry_form = get_entry_form();                          
                        $sl = 1;
                    ?>
                    @foreach($entry_form as $key => $value)
                        <tr  style="cursor:pointer" onclick="set_entry_form('{{$key}}','{{$value}}')">
                            <td width="10%">{{$sl++}}</td>
                            <td>{{$value}}</td>
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
        $("#entry_form_id").val(id);
        $("#entry_form_name").val(name);
        parent.emailwindow.hide();
    }
    setFilterGrid("list_view",-1);
</script>
@endsection