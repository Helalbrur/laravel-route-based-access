<?php
$permission = getPagePermission(request('mid') ?? 0);
?>
@extends('layouts.app')
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-12">
            <center><h1 class="m-0 align-center"><strong>Mandatory Field List</strong></h1></center>
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
                                    <label for="cbo_entry_form_name" class="col-sm-3 col-form-label must_entry_caption">Entry Form</label>
                                    <div class="col-sm-6">
                                       <input type="text" class="form-control" id="cbo_entry_form_name" name="cbo_entry_form_name" placeholder="Browse" ondblclick="loadEntryForm()" readonly>
                                       <input type="hidden" name="entry_form_id" id="entry_form_id">
                                    </div>
                                </div>
                                <div class="row mt-10">
                                    <table width="500" class="table table-bordered table-stripped rpt_table" cellpadding="0" cellspacing="0" border="1" rules="all" id="tbl_dtls" align="center">
                                        <thead>
                                            <th width="220">Field Name</th>
                                            <th width="180">Mandatory</th>
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
                                                        echo load_submit_buttons( $permission, "fnc_mandatory_field()", 0,0 ,"reset_form('mandatory_field_1','','','','','')",1); 

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
        if (form_validation('cbo_category_id*txt_item_group_name','Category Name*Item Group Name')==false)
        {
            return;
        }
        else
        {
            var formData = get_form_data('cbo_category_id,txt_item_group_name,txt_item_group_code,update_id');
            var method ="POST";
            var param = "";
            if(operation == 1 || operation == 2)
            {
                param = `/${document.getElementById('update_id').value}`;
                if(operation == 1) formData.append('_method', 'PUT');
                else formData.append('_method', 'DELETE');
            }
            formData.append('_token', '{{csrf_token()}}');
            var url = `/tools/mandatory_field${param}`;
            var requestData = {
                method: method,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                body: formData
            };

            save_update_delete(operation,url,requestData,'id','show_item_group_list_view','list_view_div','mandatoryfield_1');
        }
    }

    const load_php_data_to_form =async (menuId) =>
    {
        reset_form('mandatoryfield_1','','',1);
        var columns = 'item_category_id*item_name*item_group_code*id';
        var fields = 'cbo_category_id*txt_item_group_name*txt_item_group_code*update_id';
       var get_return_value = await populate_form_data('id',menuId,'lib_item_group',columns,fields,'{{csrf_token()}}');
       if(get_return_value == 1)
       {
         set_button_status(1, permission, 'fnc_mandatory_field',1);
       }
    }

    $("#txt_file").change(function() {
        readImage(this,'displayImage');
    });
    function loadEntryForm()
    {
        
		var title = 'Page List View';
		var page_link='/tools/mandatory_field_entry_form';
		emailwindow=dhtmlmodal.open('EmailBox', 'iframe', page_link, title, 'width=600px,height=370px,center=1,resize=1,scrolling=1','../');
		emailwindow.onclose=function()
		{
            var cbo_entry_form_name = this.contentDoc.getElementById('entry_form_name').value;
            var entry_form_id = this.contentDoc.getElementById('entry_form_id').value;
			$("#cbo_entry_form_name").val(cbo_entry_form_name);
			$("#entry_form_id").val(entry_form_id);
            fn_set_item(entry_form_id);
		}
    }
    function fn_set_item(val)
	{		
		//alert(val);
		load_drop_down( 'requires/mandatory_field_controller', val, 'load_drop_down_item', 'field_td');
		get_php_form_data(val, "action_user_data", "requires/mandatory_field_controller" );		
		
		if( $('#txt_update_data_dtls').val()!=0 )
		{
		    set_button_status(1, permission, 'fnc_mandatory_field',1);
		}
		else
		{
			set_button_status(0, permission, 'fnc_mandatory_field',1);
		}		
		
		var row_num=$('#tbl_dtls tbody tr').length;
		for (var i=1; i<=row_num; i++)
		{
			$('#cboFieldId_'+i).val(0);
			$('#cboIsMandatory_'+i).val(0);
			fn_deletebreak_down_tr(i);
		}		
		
		
		if( $('#txt_update_data_dtls').val()!=0 )
		{			
			var strs=$('#txt_update_data_dtls').val();
			var str=strs.split("@@");
			for(var i=1; i <= str.length; i++)
			{
				if(i<str.length)add_break_down_tr( i );
				var row=str[(i-1)].split("*");
				$('#cboFieldId_'+i).val(row[2]);
				$('#cboIsMandatory_'+i).val(row[4]);
			}
		}	
	}
    
</script>
@endsection
