<?php
$permission = getPagePermission(request('mid') ?? 0);
$title = getMenuName(request('mid') ?? 0) ?? 'Color Entry';
//dd(get_ip_mac("traceroute"));
//dd(get_ip_mac("tracert"));
?>
@extends('layouts.app')
@section('content_header')
<div class="row mb-2">
    <div class="col-sm-12">
        <center>
            <h1 class="m-0 align-center"><strong>{{getMenuName(request('mid') ?? 0) ?? 'Mandatory Field List'}}</strong></h1>
        </center>
    </div>
</div><!-- /.row -->
@endsection()
@section('content')
<div class="container mt-1">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-text">
                        <div class="card p-4" style="background-color:rgb(241, 241, 241)">
                            <form name="mandatoryfield_1" id="mandatoryfield_1" autocomplete="off">
                                <!-- Entry Form Name Field -->
                                <div class="mb-3 row d-flex justify-content-center">
                                    <label for="cbo_entry_form_name" class="col-sm-2 col-form-label fw-bold text-end">Entry Form</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" id="cbo_entry_form_name" name="cbo_entry_form_name" placeholder="Browse" ondblclick="loadEntryForm()" readonly />
                                        <input type="hidden" name="cbo_page_id" id="cbo_page_id" />
                                    </div>
                                </div>

                                <!-- Details Table -->
                                <div class="mb-3 row d-flex justify-content-center">
                                    <table class="table table-bordered table-striped text-center" id="tbl_dtls">
                                        <thead class="table-secondary">
                                            <tr>
                                                <th width="40%" class="text-center">Field Name</th>
                                                <th width="40%" class="text-center">Mandatory</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="dtls_body">
                                            <tr>
                                                <td id="field_td">
                                                    <?php echo create_drop_down("cboFieldId_1","100%", blank_array(), "", 1, "-- Select --", 0, "", "", "", "", "", "", "", "", "cboFieldId[]"); ?>
                                                </td>
                                                <td>
                                                    <?php echo create_drop_down("cboIsMandatory_1","100%", yes_no(), "", 1, "-- Select --", 0, "", "", "", "", "", "", "", "", "cboIsMandatory[]"); ?>
                                                </td>
                                                <td id="increment_1">
                                                    <input type="button" id="incrementfactor_1" name="incrementfactor_1" class="btn btn-success" value="+" onclick="add_break_down_tr(1)" />
                                                    <input type="button" id="decrementfactor_1" name="decrementfactor_1" class="btn btn-danger" value="-" onclick="fn_deletebreak_down_tr(1)" />
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="3" align="center">
                                                    <?php echo load_submit_buttons($permission, "fnc_mandatory_field()", 0, 0, "reset_form('mandatoryfield_1','','','','','')", 1); ?>
                                                    <input type="hidden" id="txt_update_data_dtls" readonly disabled />
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
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
    var permission = '{{$permission}}';

    function fnc_mandatory_field(operation) {
        if (form_validation('cbo_page_id', 'Page Name') == false) {
            return;
        } else {

            var field_id_arr = new Array();
            var row_num = $('#tbl_dtls tbody tr').length;
            var field = 'cbo_page_id';
            for (var i = 1; i <= row_num; i++) {
                var cboFieldId = $('#cboFieldId_' + i).val();
                if (cboFieldId != 0) {
                    if (jQuery.inArray($('#cboFieldId_' + i).val(), field_id_arr) == -1) {
                        field_id_arr.push($('#cboFieldId_' + i).val());
                    } else {
                        alert("Duplicate Field Name Not Allow");
                        return;
                    }
                }
                field += ',cboFieldId_' + i + ',cboIsMandatory_' + i;
            }
            var formData = get_form_data(field);
            var method = "POST";

            formData.append('_token', '{{csrf_token()}}');
            formData.append('total_row', row_num);
            formData.append('operation', operation);
            var url = `{{URL::to('/tools/mandatory_field')}}`;
            var requestData = {
                method: method,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                body: formData
            };

            save_update_delete(operation, url, requestData);
            fn_set_item($('#cbo_page_id').val());

        }

    }

    function loadEntryForm() {

        var title = 'Page List View';
        var page_link = '/tools/mandatory_field_entry_form';
        emailwindow = dhtmlmodal.open('EmailBox', 'iframe', page_link, title, 'width=500px,height=370px,center=1,resize=1,scrolling=1', '../');
        emailwindow.onclose = function() {
            var cbo_entry_form_name = this.contentDoc.getElementById('entry_form_name').value;
            var entry_form_id = this.contentDoc.getElementById('entry_form_id').value;
            $("#cbo_entry_form_name").val(cbo_entry_form_name);
            $("#cbo_page_id").val(entry_form_id);
            fn_set_item(entry_form_id);
        }
    }

    function fn_set_item(val) {
        load_drop_down('tools/load_drop_down_mandatory_field_item', val, 'tools/load_drop_down_mandatory_field_item', 'field_td')
        var url = `{{URL::to('tools/mandatory_action_user_data')}}`;
        url = `${url}?data=${val}`;
        fetch(url, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{csrf_token()}}' // Add the CSRF token to the headers
                }
            })
            .then(response => response.json())
            .then(data => {
                try {
                    if (data.length > 0) {
                        //$('#txt_update_data_dtls').val(data);
                        set_button_status(1, permission, 'fnc_mandatory_field', 1);
                        var row_num = $('#tbl_dtls tbody tr').length;
                        for (var i = 1; i <= row_num; i++) {
                            $('#cboFieldId_' + i).val(0).trigger('change');
                            $('#cboIsMandatory_' + i).val(0).trigger('change');
                            fn_deletebreak_down_tr(i);
                        }
                        var i = 1;
                        for (row of data) {
                            if (i < data.length) add_break_down_tr(i);
                            $('#cboFieldId_' + i).val(row.field_id).trigger('change');
                            $('#cboIsMandatory_' + i).val(row.is_mandatory).trigger('change');
                            i++;
                        }
                    } else {
                        var row_num = $('#tbl_dtls tbody tr').length;
                        for (var i = 1; i <= row_num; i++) {
                            $('#cboFieldId_' + i).val(0).trigger('change');
                            $('#cboIsMandatory_' + i).val(0).trigger('change');
                            fn_deletebreak_down_tr(i);
                        }
                        set_button_status(0, permission, 'fnc_mandatory_field', 1);
                    }
                } catch (error) {
                    throw new Error(error);
                }
            })
            .catch(error => {
                var row_num = $('#tbl_dtls tbody tr').length;
                for (var i = 1; i <= row_num; i++) {
                    $('#cboFieldId_' + i).val(0).trigger('change');
                    $('#cboIsMandatory_' + i).val(0).trigger('change');
                    fn_deletebreak_down_tr(i);
                }
                showNotification(error, 'error');
            });
        //console.log($('#txt_update_data_dtls').val());

    }

   

    
    function add_break_down_tr_backup(i) {
        var chargefor = 0;
        var row_num = $('#tbl_dtls tbody tr').length;
        if (row_num != i) {
            return false;
        }
        i++;

        if (form_validation('cbo_page_id', 'Page Name') == false) {
            alert("Please Select Page Name Field");
            return;
        }

        $("#tbl_dtls tbody tr:last").clone().find("input,select").each(function() {
            $(this).attr({
                'id': function(_, id) {
                    var id = id.split("_");
                    return id[0] + "_" + i;
                },
                'name': function(_, name) {
                    var name = name.split("_");
                    return name[0];
                },
                'value': function(_, value) {
                    return value;
                }
            });

        }).end().appendTo("#tbl_dtls");


        $('#incrementfactor_' + i).removeAttr("onClick").attr("onClick", "add_break_down_tr(" + i + ");");
        $('#decrementfactor_' + i).removeAttr("onClick").attr("onClick", "fn_deletebreak_down_tr(" + i + ");");

    }

    function add_break_down_tr(i) {
        var chargefor = 0;
        var row_num = $('#tbl_dtls tbody tr').length;
        if (row_num != i) {
            return false;
        }
        i++;

        if (form_validation('cbo_page_id', 'Page Name') == false) {
            alert("Please Select Page Name Field");
            return;
        }

        // Clone the row and clean up Select2 elements
        var newRow = $("#tbl_dtls tbody tr:last").clone()
            .find('select').each(function() {
                $(this).removeClass('select2-hidden-accessible')
                    .next('.select2-container').remove()
                    .removeAttr('data-select2-id');
            }).end()
            
            // Update IDs, names and values for inputs/selects
            .find("input,select").each(function() {
                $(this).attr({
                    'id': function(_, id) {
                        var id = id.split("_");
                        id.pop();
                        return id.join("_") + "_" + i;
                    },
                    'name': function(_, name) {
                        var name = name.split("_");
                        return name; // Fixed to include index in name
                    },
                    'value': function(_, value) {
                        return $(this).is('select') ? '0' : ''; // Reset values
                    }
                });
            }).end()
            
            // Add to table
            .appendTo("#tbl_dtls");

        // Initialize Select2 for new selects
        newRow.find('select').select2({
            width: '100%',
            dropdownParent: newRow.closest('.modal').length ? 
            newRow.closest('.modal') : document.body
        });

        // Update button events
        $('#incrementfactor_' + i).removeAttr("onClick").attr("onClick", "add_break_down_tr(" + i + ");").val("+");
        $('#decrementfactor_' + i).removeAttr("onClick").attr("onClick", "fn_deletebreak_down_tr(" + i + ");").val("-");
        initializeSelect2();
    }

    function fn_deletebreak_down_tr(rowNo) {
        if (rowNo != 1) {
            var index = rowNo - 1
            $("#tbl_dtls tbody tr:eq(" + index + ")").remove();
            var numRow = $('#tbl_dtls tbody tr').length;
            for (i = rowNo; i <= numRow; i++) {
                $("#tbl_dtls tr:eq(" + i + ")").find("input,select").each(function() {
                    $(this).attr({
                        'id': function(_, id) {
                            var id = id.split("_");
                            id.pop();
                            return id.join("_") + "_" + i
                        },
                        'value': function(_, value) {
                            return value
                        }
                    });

                    $('#incrementfactor_' + i).removeAttr("onClick").attr("onClick", "add_break_down_tr(" + i + ");");
                    $('#decrementfactor_' + i).removeAttr("onClick").attr("onClick", "fn_deletebreak_down_tr(" + i + ")");
                })

            }
        }
    }
    
</script>
@endsection