
<?php
$permission = getPagePermission(request('mid') ?? 0);
?>
@extends('layouts.app')
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 align-center"><strong>Manual Database Backup</strong></h1>
        </div>
       
    </div><!-- /.row -->
@endsection()
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">

            <h5 class="card-title"></h5>
            <div class="card-text">
                <!-- #EBF4FA; -->
                <div class="card" style="background-color: #F5FFFA">
                    <form name="db_backup" id="db_backup" autocomplete="off" style="padding: 10px;">
                        
						<div class="from-group row">
							
                            <div class="col-sm-8">
                                <p id="response_text"></p>
                            </div>
                        </div>
                        <div class="from-group row">
							
                            <div class="col-sm-8">
                                <?php
                                    echo load_submit_buttons( $permission, "fnc_db_backup", 0,0 ,"");
                                ?>
                            </div>
                        </div>
                    </form>
                </div>
                
            </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
    function fnc_db_backup( operation )
    {
        
		var method ="POST";
		fetch(`/db_backup`, {
			method: method ,
			headers: {
				'Content-Type': 'application/json',
				'X-Requested-With': 'XMLHttpRequest',
				'X-CSRF-TOKEN': '{{csrf_token()}}'// Add the CSRF token to the headers
			},
			body: JSON.stringify({
				_token:'{{csrf_token()}}'
			})
		})
		.then(response => {
			if (!response.ok) {
				throw new Error('Network response was not ok');
			}
			return response.json();
		})
		.then(data => {
			showNotification(operation_success_msg[operation]);
			$("#response_text").text(data.data)
		})
		.catch(error => {
			showNotification(error,'error');
			console.error(error);
		});
        
    }
    
</script>
@endsection


