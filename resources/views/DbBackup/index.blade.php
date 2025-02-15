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
<div class="container mt-1">
    <div class="row justify-content-center"> <!-- Center the row -->
        <div class="col-lg-6"> <!-- Keeps card width controlled -->
            <div class="card mx-auto"> <!-- Center the card horizontally -->
                <div class="card-body text-center"> <!-- Center content inside the card -->
                    <h3>Manual Database Backup</h3>
                    <div class="card-text">
                        <div class="card p-4" style="background-color: rgb(241, 241, 241);">
                            <form name="db_backup" id="db_backup" autocomplete="off" class="text-center">
                                <div class="form-group">
                                    <p id="response_text"></p>
                                </div>
                                <div class="form-group">
                                    <?php
                                    echo load_submit_buttons($permission, "fnc_db_backup", 0, 0, "", "", "", 1);
                                    ?>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
    function fnc_db_backup(operation) {

        var method = "POST";
        fetch(`/db_backup`, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{csrf_token()}}' // Add the CSRF token to the headers
                },
                body: JSON.stringify({
                    _token: '{{csrf_token()}}'
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
                showNotification(error, 'error');
                console.error(error);
            });

    }
</script>
@endsection