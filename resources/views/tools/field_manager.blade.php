<?php
$permission = getPagePermission(request('mid') ?? 0);
$title = getMenuName(request('mid') ?? 0) ?? 'Field Manager';

?>
@extends('layouts.app')
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-12">
            <center><h1 class="m-0 align-center"><strong>{{getMenuName(request('mid') ?? 0) ?? 'Field Manager'}}</strong></h1></center>
        </div>
    </div><!-- /.row -->
@endsection()
@section('content')
<div class="row">
    <div class="col-lg-12">
        <center>
            <div class="card" style="justify-content:center;width: 80%;">
                <div class="card-body" style="justify-content:center;">
                    <div class="card-text" style="justify-content:center;">
                        <!-- #EBF4FA; -->
                        <div class="card" style="background-color: #F5FFFA;justify-content:center;text-align:center">
                            <form name="mandatoryfield_1" id="mandatoryfield_1" autocomplete="off" style="padding: 10px;">
                                
                                <div class="form-group row">
                                    <label for="cbo_entry_form_name" class="col-sm-2 col-form-label must_entry_caption">Entry Form</label>
                                    <div class="col-sm-4">
                                       <input type="text" class="form-control" id="cbo_entry_form_name" name="cbo_entry_form_name" placeholder="Browse" ondblclick="loadEntryForm()" readonly>
                                       <input type="hidden" name="cbo_page_id" id="cbo_page_id">
                                    </div>

                                    <label for="cbo_entry_form_name" class="col-sm-2 col-form-label must_entry_caption">User</label>
                                    <div class="col-sm-4">
                                       
                                       <?php echo create_drop_down("cbo_user_id",200,get_all_user(),"",1,"----Select----",0,"","","","","","","",""); ?>
                                       
                                    </div>
                                </div>
                                <div class="row mt-10">
                                    <table width="70%" class="table table-bordered table-stripped rpt_table" cellpadding="0" cellspacing="0" border="1" rules="all" id="tbl_dtls" align="center">
                                        <thead>
                                            <th width="40%">Field Name</th>
                                            <th width="40%">Is Hide</th>
                                            <th></th>
                                        </thead>
                                        <tbody id="dtls_body">
                                            <tr>
                                                <td align="center" id="field_td">
                                                    <?php echo create_drop_down("cboFieldId_1",200,blank_array(),"",1,"----Select----",0,"","","","","","","","","cbo_field_id[]"); ?>
                                                </td>
                                                <td align="center">
                                                    <?php echo create_drop_down("cboIsMandatory_1",150,yes_no(),"",1,"-- Select --",0,"","","","","","","","","cbo_permission_id[]"); ?> 
                                                </td>
                                                <td align="center" id="increment_1">
                                                    <input style="width:30px;" type="button" id="incrementfactor_1" name="incrementfactor_1"  class="formbutton" value="+" onClick="add_break_down_tr(1)"/>
                                                    <input style="width:30px;" type="button" id="decrementfactor_1" name="decrementfactor_1"  class="formbutton" value="-" onClick="javascript:fn_deletebreak_down_tr(1)"/>&nbsp;
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="3" align="center" style="padding-top:10px;" class="button_container">
                                                    <?php 
                                                        echo load_submit_buttons( $permission, "fnc_mandatory_field()", 0,0 ,"reset_form('mandatoryfield_1','','','','','')",1); 

                                                    ?>
                                                    <input type="hidden" id="txt_update_data_dtls" readonly disabled>
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
        </center>
    </div>
</div>

@endsection

@section('script')
<script>
    var permission ='{{$permission}}';
    function fnc_mandatory_field( operation )
    {
        if (form_validation('cbo_page_id','Page Name')==false)
        {
            return;
        }
		else
		{
		
			var field_id_arr=new Array();
			var row_num=$('#tbl_dtls tbody tr').length;
			var field='cbo_page_id';
			for (var i=1; i<=row_num; i++)
			{
				var cboFieldId=$('#cboFieldId_'+i).val();
				if(cboFieldId!=0)
                {
					if( jQuery.inArray( $('#cboFieldId_' + i).val(), field_id_arr ) == -1 )
					{
						field_id_arr.push( $('#cboFieldId_' + i).val() );
					}
					else
					{
						alert("Duplicate Field Name Not Allow");return;
					}
				}
				field+=',cboFieldId_'+i+',cboIsMandatory_'+i;
			}
            var formData = get_form_data(field);
            var method ="POST";
           
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

            save_update_delete(operation,url,requestData);
            fn_set_item($('#cbo_page_id').val());
        
		}
        
    }

    function loadEntryForm()
    {
        
		var title = 'Page List View';
		var page_link='/tools/mandatory_field_entry_form';
		emailwindow=dhtmlmodal.open('EmailBox', 'iframe', page_link, title, 'width=500px,height=370px,center=1,resize=1,scrolling=1','../');
		emailwindow.onclose= function()
		{
            var cbo_entry_form_name = this.contentDoc.getElementById('entry_form_name').value;
            var entry_form_id = this.contentDoc.getElementById('entry_form_id').value;
			$("#cbo_entry_form_name").val(cbo_entry_form_name);
			$("#cbo_page_id").val(entry_form_id);
           fn_set_item(entry_form_id);
		}
    }
    function fn_set_item(val)
	{		
        load_drop_down( 'tools/load_drop_down_field_manager_item', val, 'tools/load_drop_down_field_manager_item', 'field_td' )
        var url = `{{URL::to('tools/field_manager_action_user_data')}}`;
        var data = {
            entry_form: val,
            user_id: document.getElementById("cbo_user_id").value
        }	
        url = `${url}?data=${JSON.stringify(data)}`;
        fetch(url,{
                method: 'GET' ,
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{csrf_token()}}'// Add the CSRF token to the headers
                }
            })
            .then(response => response.json())
            .then(data => {
                try
                {
                    if(data.length > 0 )
                    {
                        //$('#txt_update_data_dtls').val(data);
                        set_button_status(1, permission, 'fnc_mandatory_field',1);
                        var row_num=$('#tbl_dtls tbody tr').length;
                        for (var i=1; i<=row_num; i++)
                        {
                            $('#cboFieldId_'+i).val(0);
                            $('#cboIsMandatory_'+i).val(0);
                            fn_deletebreak_down_tr(i);
                        }		
                        var i = 1;
                        for(row of data)
                        {
                            if(i<data.length)add_break_down_tr( i );
                            $('#cboFieldId_'+i).val(row.field_id);
                            $('#cboIsMandatory_'+i).val(row.is_mandatory);
                           i++;
                        }
                    }
                    else
                    {
                        var row_num=$('#tbl_dtls tbody tr').length;
                        for (var i=1; i<=row_num; i++)
                        {
                            $('#cboFieldId_'+i).val(0);
                            $('#cboIsMandatory_'+i).val(0);
                            fn_deletebreak_down_tr(i);
                        }
                        set_button_status(0, permission, 'fnc_mandatory_field',1);
                    }
                }
                catch (error)
                {
                    throw new Error(error);
                }
            })
            .catch(error => {
                var row_num=$('#tbl_dtls tbody tr').length;
                for (var i=1; i<=row_num; i++)
                {
                    $('#cboFieldId_'+i).val(0);
                    $('#cboIsMandatory_'+i).val(0);
                    fn_deletebreak_down_tr(i);
                }
                showNotification(error,'error');
            });
        //console.log($('#txt_update_data_dtls').val());
		
	}

    function add_break_down_tr( i) 
	{
		var chargefor=0;
		var row_num=$('#tbl_dtls tbody tr').length;
		if (row_num!=i)
		{
			return false;
		}
		i++;
		
		if(form_validation('cbo_page_id','Page Name')==false)
		{
			alert("Please Select Page Name Field"); return;
		}
		
		$("#tbl_dtls tbody tr:last").clone().find("input,select").each(function() {
			$(this).attr({
			'id': function(_, id) { var id=id.split("_"); return id[0] +"_"+ i; },
			'name': function(_, name) { var name=name.split("_"); return name[0]; },
			'value': function(_, value) { return value ; }              
			});
			
		}).end().appendTo("#tbl_dtls");

		  
		  $('#incrementfactor_'+i).removeAttr("onClick").attr("onClick","add_break_down_tr("+i+");");
		  $('#decrementfactor_'+i).removeAttr("onClick").attr("onClick","fn_deletebreak_down_tr("+i+");");
		  
	}

    function fn_deletebreak_down_tr(rowNo) 
	{
		if(rowNo!=1)
		{
			var index=rowNo-1
			$("#tbl_dtls tbody tr:eq("+index+")").remove();
			var numRow=$('#tbl_dtls tbody tr').length;
			for(i = rowNo;i <= numRow;i++){
				$("#tbl_dtls tr:eq("+i+")").find("input,select").each(function() {
					$(this).attr({
					  'id': function(_, id) { var id=id.split("_"); return id[0] +"_"+ i },
					  'value': function(_, value) { return value }              
					}); 
					
				$('#incrementfactor_'+i).removeAttr("onClick").attr("onClick","add_break_down_tr("+i+");");
				$('#decrementfactor_'+i).removeAttr("onClick").attr("onClick","fn_deletebreak_down_tr("+i+")");
				})

			}
		}		
	}
    
</script>
@endsection
