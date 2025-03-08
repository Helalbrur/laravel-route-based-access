@extends('layouts.popup')
@section('content')
<h3 style="justify-content: center;text-align:center">Sys No/ Id : {{$sys_no}} , Page : {{ucwords(str_replace('_',' ',$page_name))}}</h3>
<div style="max-height: 250px;overflow-y: scroll;">
    <table class="table table-striped" >
        <tbody >
            <?php
                $sl = 1;
                $images = App\Models\ImageUpload::where('sys_no',$sys_no)
                                            ->where('page_name',$page_name);
                if(!empty($file_type))
                {
                    $images = $images->where('file_type',$file_type);
                }

                $images = $images->get();                            
            
            ?>
            @foreach($images as $image)
                <tr id="row_{{$image->id}}" style="cursor:pointer">
                    <td>
                        @if(!empty($image->file_name) && $image->file_type==1)
                            <a href="{{asset($image->file_name)}}" download><img src="{{asset($image->file_name)}}" height="150" width="200" download></a>
                        @elseif(!empty($image->file_name))
                            <a href="{{asset($image->file_name)}}" download><img src="{{asset('image/download.png')}}" height="45" width="55"></a>
                        @endif
                    </td>
                    <td>
                        <input type="button" class="btn btn-sm btn-danger" value="Delete" onclick="confirmDelete('{{$image->id}}');">
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<center>
    <input type="button"  class="btn btn-sm btn-info" value="Close" onclick="parent.emailwindow.hide();">
</center>
@endsection

@section('script')
<script>
    function confirmDelete(itemId) 
    {
        if (confirm("Are you sure you want to delete this item?"))
        {
            const formData = new FormData();
           
            formData.append('_method', 'DELETE');
            formData.append('_token', '{{csrf_token()}}');
            formData.append('id', itemId);
            var requestData = {
                method: "POST",
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                body: formData
            };

            fetch(`/file_delete/${itemId}`,requestData )
            .then(response => response.json())
            .then(data => {
                showNotification(operation_success_msg[data.code]);
                if(data.code == 2)
                {
                    var row = document.getElementById("row_" + itemId);
                    row.remove();
                }
            })
            .catch(error => {
                showNotification(error,'error');
            });
        }
    }
</script>
@endsection