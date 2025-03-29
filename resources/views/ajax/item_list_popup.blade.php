@extends('layouts.popup')
@section('content')
<div>
    <input type="hidden" id="item_id" >
    <input type="hidden" id="item_name" >
    <table class="table table-striped table-bordered bg-secondary" style="width:300px;margin-bottom:0px;padding-bottom:0px;">
        <tbody>
            <tr>
                <th width="10%"><strong>Sl</strong></th>
                <th><strong>Item Name</strong></th>
            </tr>
        </tbody>
    </table>
    <div style="max-height: 290px;overflow-y: scroll;width:300px">
        <table class="table table-striped table-bordered" style="width:300px">
            <tbody id="list_view">
                <?php
                    $items = App\Models\ProductDetailsMaster::pluck('item_description', 'id'); 
                    $sl = 1;
                ?>
                @foreach($items as $id => $item_description)
                    <tr style="cursor:pointer" onclick="set_item('{{$id}}', '{{$item_description}}')">
                        <td width="10%">{{$sl++}}</td>
                        <td>{{$item_description}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection

@section('script')
<script>
    function set_item(item_id,item_description) 
    {
        $("#item_id").val(item_id);
        $("#item_name").val(item_description);
        parent.emailwindow.hide();
    }
    setFilterGrid("list_view",-1);
</script>
@endsection