
function set_multiselect( fld_id, max_selection, is_update, update_values, on_close_fnc_param, on_close_fnc )
{

	if (!on_close_fnc_param) var on_close_fnc_param="";
	else
	{
		on_close_fnc_param=on_close_fnc_param.split("*");
	}

	if(!on_close_fnc){var on_close_fnc='';}
	else{ var on_close_fnc=' ;'+on_close_fnc;}
	
	
	fld_id=fld_id.split("*");
	max_selection=max_selection.split("*");
	update_values=update_values.split("*");
	if (is_update!=1)  // New List Creation
	{
		for ( var i=0; i<fld_id.length; i++ )
		{
			var html_list="";
			var elm_width=document.getElementById(fld_id[i]).offsetWidth-12;
			var elm_height=document.getElementById(fld_id[i]).offsetHeight;
			var onc="'"+on_close_fnc_param[i]+"'";
			var j=0;
			var opts = $('#'+fld_id[i])[0].options;
		 	if (max_selection[i]==0) max_selection[i]=opts.length;
			var max_select=max_selection[i];

			// added from HRM 3rd version by - Jahid Hasan
			var id_str="'";
			var m=0;
			$.map(opts, function( elem ){
				if(m!=0) id_str+=",";
				id_str+=elem.value;
				m++;
			});
			id_str+="'";
			//

			var closed='<span style="position:absolute; right:5px; width:15px;"><a href="##" style="text-decoration:none"> X </a></span>';
		
			html_list ='<div class="multiselect_dropdown_table" id="multi_select_'+fld_id[i]+'" style="display:none; width:'+((elm_width*1)+12)+'px; max-height:'+170+'px; min-height:'+50+'px; position:absolute; z-index:30"><table border="1" width="100%" class="multiselect_dropdown_table_top" >';	
			
			html_list=html_list+'<thead><tr ><th colspan="2" height="20" id="multiselect_dropdown_table_header'+fld_id[i]+'" align="center" ><span href="##" onclick="disappear_list('+fld_id[i]+','+onc+') '+on_close_fnc+'"><b>Select Max '+max_select+' Item</b>'+closed+'</span></th></tr><tr><th><input type="checkbox" id="check_all_'+fld_id[i]+'" onclick="fnc_multi_check_all('+fld_id[i]+','+id_str+')"></th></a><th>Check All</th></tr></thead></table><div class="mylistview" style="overflow-y:scroll;max-height:'+140+'px; min-height:'+20+'px;"><table border="1" width="100%" id="table_body'+fld_id[i]+'" class="multiselect_dropdown_table_bottom" >';

			var array = $.map(opts, function( elem ) {
				//id_array[i]=elem.value;
				//option_array[i]= elem.text;
				j++;
				html_list=html_list+'<tr id="tr'+fld_id[i]+elem.value+'" class="multiselect_mouse_out" onMouseOver="make_selection('+fld_id[i]+','+elem.value+')" onMouseOut="make_selection_remove('+fld_id[i]+','+elem.value+')" ><td width="15"><input type="checkbox" onclick="add_multiselect_listitems('+fld_id[i]+', '+elem.value+','+opts.length+','+max_selection[i]+')" id="'+fld_id[i]+elem.value+'"></td><td onclick="add_multiselect_listitems('+fld_id[i]+', '+elem.value+','+opts.length+','+max_selection[i]+')">'+elem.text+'</td></tr>';
				/*html_list=html_list+'<tr id="tr'+fld_id[i]+elem.value+'" class="multiselect_mouse_out" onMouseOver="make_selection('+fld_id[i]+','+elem.value+')" ><td width="15"><input type="checkbox" onclick="add_multiselect_listitems('+fld_id[i]+', '+elem.value+','+opts.length+','+max_selection[i]+')" id="'+fld_id[i]+elem.value+'"></td><td onclick="add_multiselect_listitems('+fld_id[i]+', '+elem.value+','+opts.length+','+max_selection[i]+')">'+elem.text+'</td></tr>';*/

			});
			html_list=html_list+'</table></div></div>';
			$('#'+fld_id[i]).replaceWith('<input id="show_text'+fld_id[i]+'" placeholder="Select Multiple Item" readonly type="text" class="text_boxes" style="text-align:center; width:'+elm_width+'px; height:'+elm_height+'px" onclick="append_list('+fld_id[i]+')"/>'+html_list +'<input type="hidden" id="'+fld_id[i]+'" class="text_boxes" />');

		}

	}  // New List Creation Ends

	else   // List Populate Here for Upadte Options or Previously Selected values
	{
		//alert(is_update)
		for ( var i=0; i<fld_id.length; i++ )
		{
			var rowCount = $('#table_body'+fld_id[i]+' tr').length;
		//alert(rowCount);
			$('#table_body'+fld_id[i]+' input:checkbox').removeAttr('checked');  // Uncheck all Previuosly Selected box

			$('#show_text'+fld_id[i]).val('');
			document.getElementById(fld_id[i]).value='';

			var values_sub=update_values[i].split(",");
		 	if (max_selection[i]==0) max_selection[i]=rowCount;
			var max_select=max_selection[i];
			for (var k=0; k < values_sub.length; k++)
			{
				if (values_sub[k]!="")
					add_multiselect_listitems_update(fld_id[i], values_sub[k], rowCount, max_selection[i]);
			}
			disappear_list_update(fld_id[i],on_close_fnc_param[i]);
		}

		// alert('asdas');
	}

}

// function set_multiselect_backup( fld_id, max_selection, is_update, update_values, on_close_fnc_param, on_close_fnc )
// {

// 	if (!on_close_fnc_param) var on_close_fnc_param="";
// 	else
// 	{
// 		on_close_fnc_param=on_close_fnc_param.split("*");
// 	}

// 	if(!on_close_fnc){var on_close_fnc='';}
// 	else{ var on_close_fnc=' ;'+on_close_fnc;}
	
	
// 	fld_id=fld_id.split("*");
// 	max_selection=max_selection.split("*");
// 	update_values=update_values.split("*");
// 	if (is_update!=1)  // New List Creation
// 	{
// 		for ( var i=0; i<fld_id.length; i++ )
// 		{
// 			var html_list="";
// 			var elm_width=document.getElementById(fld_id[i]).offsetWidth-12;
// 			var elm_height=document.getElementById(fld_id[i]).offsetHeight;
// 			var onc="'"+on_close_fnc_param[i]+"'";
// 			var j=0;
// 			var opts = $('#'+fld_id[i])[0].options;
// 		 	if (max_selection[i]==0) max_selection[i]=opts.length;
// 			var max_select=max_selection[i];

// 			// added from HRM 3rd version by - Jahid Hasan
// 			var id_str="'";
// 			var m=0;
// 			$.map(opts, function( elem ){
// 				if(m!=0) id_str+=",";
// 				id_str+=elem.value;
// 				m++;
// 			});
// 			id_str+="'";
// 			//

// 			var closed='<span style="position:absolute; right:5px; width:15px;"><a href="##" style="text-decoration:none" onclick="disappear_list('+fld_id[i]+','+onc+') '+on_close_fnc+'"> X </a></span>';
// 			html_list ='<div class="multiselect_dropdown_table" id="multi_select_'+fld_id[i]+'" style="display:none; width:'+((elm_width*1)+12)+'px; max-height:'+170+'px; min-height:'+50+'px; position:absolute;"><table border="1" width="100%" class="multiselect_dropdown_table_top" >';
// 			html_list=html_list+'<thead><tr><th colspan="2" height="20" id="multiselect_dropdown_table_header'+fld_id[i]+'" align="center"><b>Select Max '+max_select+' Item</b>'+closed+'</th></tr><tr><th><input type="checkbox" id="check_all_'+fld_id[i]+'" onclick="fnc_multi_check_all('+fld_id[i]+','+id_str+')"></th><th>Check All</th></tr></thead></table><div class="mylistview" style="overflow-y:scroll;max-height:'+140+'px; min-height:'+20+'px;"><table border="1" width="100%" id="table_body'+fld_id[i]+'" class="multiselect_dropdown_table_bottom" >';
// 			var array = $.map(opts, function( elem ) {
// 				//id_array[i]=elem.value;
// 				//option_array[i]= elem.text;
// 				j++;
// 				html_list=html_list+'<tr id="tr'+fld_id[i]+elem.value+'" class="multiselect_mouse_out" onMouseOver="make_selection('+fld_id[i]+','+elem.value+')" onMouseOut="make_selection_remove('+fld_id[i]+','+elem.value+')" ><td width="15"><input type="checkbox" onclick="add_multiselect_listitems('+fld_id[i]+', '+elem.value+','+opts.length+','+max_selection[i]+')" id="'+fld_id[i]+elem.value+'"></td><td onclick="add_multiselect_listitems('+fld_id[i]+', '+elem.value+','+opts.length+','+max_selection[i]+')">'+elem.text+'</td></tr>';
// 				/*html_list=html_list+'<tr id="tr'+fld_id[i]+elem.value+'" class="multiselect_mouse_out" onMouseOver="make_selection('+fld_id[i]+','+elem.value+')" ><td width="15"><input type="checkbox" onclick="add_multiselect_listitems('+fld_id[i]+', '+elem.value+','+opts.length+','+max_selection[i]+')" id="'+fld_id[i]+elem.value+'"></td><td onclick="add_multiselect_listitems('+fld_id[i]+', '+elem.value+','+opts.length+','+max_selection[i]+')">'+elem.text+'</td></tr>';*/

// 			});
// 			html_list=html_list+'</table></div></div>';
// 			$('#'+fld_id[i]).replaceWith('<input id="show_text'+fld_id[i]+'" placeholder="Select Multiple Item" readonly type="text" class="text_boxes" style="text-align:center; width:'+elm_width+'px; height:'+elm_height+'px" onclick="append_list('+fld_id[i]+')"/>'+html_list +'<input type="hidden" id="'+fld_id[i]+'" class="text_boxes" />');

// 		}

// 	}  // New List Creation Ends

// 	else   // List Populate Here for Upadte Options or Previously Selected values
// 	{
// 		//alert(is_update)
// 		for ( var i=0; i<fld_id.length; i++ )
// 		{
// 			var rowCount = $('#table_body'+fld_id[i]+' tr').length;

// 			$('#table_body'+fld_id[i]+' input:checkbox').removeAttr('checked');  // Uncheck all Previuosly Selected box

// 			$('#show_text'+fld_id[i]).val('');
// 			document.getElementById(fld_id[i]).value='';

// 			var values_sub=update_values[i].split(",");
// 		 	if (max_selection[i]==0) max_selection[i]=rowCount;
// 			var max_select=max_selection[i];
// 			for (var k=0; k < values_sub.length; k++)
// 			{
// 				if (values_sub[k]!="")
// 					add_multiselect_listitems_update(fld_id[i], values_sub[k], rowCount, max_selection[i]);
// 			}
// 			disappear_list_update(fld_id[i],on_close_fnc_param[i]);
// 		}

// 		//alert('asdas');
// 	}

// }

function append_list(fld)
{
	$("#multi_select_"+fld.id).show("slow");
	$('.multiselect_dropdown_table').mouseleave(function() {
		 //$("#multi_select_"+fld.id).hide("slow");
	});


	if ($("#flt1_tbl_task_list").length == 0){
		$("#table_body"+fld.id +" .fltrow").remove();
		var tableFilters = { col_0:'none' };
	 	setFilterGrid("table_body"+fld.id,-1,tableFilters);
	}


}

function disappear_list(fld,close_fnc)
{
	if(!close_fnc) var close_fnc=0;
	 if(close_fnc!=0)
	 {
		 close_fnc=close_fnc.split('__');
	  if (close_fnc[0]=="") close_fnc[0]=fld.value;
	 	get_php_form_data( close_fnc[0], close_fnc[1], close_fnc[2] );
	 }

	$("#multi_select_"+fld.id).hide("slow");
}

function disappear_list_update(fld,close_fnc)
{
	//alert(fld)
	 if(close_fnc!=0)
	 {
		 close_fnc=close_fnc.split('__');
	  if (close_fnc[0]=="") close_fnc[0]=document.getElementById(fld).value;
	 	get_php_form_data( close_fnc[0], close_fnc[1], close_fnc[2] );
	 }

	 $("#multi_select_"+fld.id).hide("slow");
}

function make_selection(fld,id)
{
	$('#tr'+fld.id+id).removeClass('multiselect_mouse_out').addClass('multiselect_mouse_over');
}

function make_selection_remove(fld,id)
{
	$('#tr'+fld.id+id).removeClass('multiselect_mouse_over').addClass('multiselect_mouse_out');
}

function add_multiselect_listitems( id, val, total, max_sel)
{

	var old_data=id.value.split(',');

		var ind=inArray(val, old_data);
		if (ind==-1)
		{
			if (old_data.length>=max_sel && id.value!="")
			{
				$('#'+id.id+val).removeAttr('checked');
				alert('You Can Select Only '+max_sel+' Records');
				return false;
			}
			$('#'+id.id+val).attr('checked','checked');
			if ( id.value!="" ) id.value=id.value+","+val; else id.value=val;
		}
		else
		{
			$('#'+id.id+val).removeAttr('checked');
			old_data.splice(ind,1); //old_data.splice(pos, 1);
			id.value=old_data;
		}
		if (id.value!="")
		{
			var old_data=id.value.split(',');
			$('#show_text'+id.id).val(old_data.length+' Out of '+ total +' Selected');
		}
		else
		 	$('#show_text'+id.id).val('');

}

function add_multiselect_listitems_update( id, val, total, max_sel)
{

	var old_data=document.getElementById(id).value.split(',');

		var ind=inArray(val, old_data);
		if (ind==-1)
		{
			if (old_data.length>=max_sel && document.getElementById(id).value!="")
			{
				$('#'+id+val).removeAttr('checked');
				alert('You Can Select Only '+max_sel+' Records');
				return false;
			}
			$('#'+id+val).attr('checked','checked');
			if ( document.getElementById(id).value!="" ) document.getElementById(id).value=document.getElementById(id).value+","+val; else document.getElementById(id).value=val;
		}
		else
		{
			$('#'+id+val).removeAttr('checked');
			old_data.splice(ind,1); //old_data.splice(pos, 1);
			document.getElementById(id).value=old_data;
		}
		if (document.getElementById(id).value!="")
		{
			var old_data=document.getElementById(id).value.split(',');
			$('#show_text'+id).val(old_data.length+' Out of '+ total +' Selected');
		}
		else
		 	$('#show_text'+id).val('');

}



function inArray(data, array) {
    var length = array.length;
    for(var i = 0; i < length; i++) {
        if(array[i] == data) return i;
    }
    return -1;
}

//set_multiselect('cbo_status*supplier_nature','1*3','1','1*2_3_5');  Update
//set_multiselect('cbo_status*supplier_nature','1*3','0',''); New

// added from HRM 3rd version by - Jahid Hasan
function fnc_multi_check_all(id,str)
{
	var data=str.split(",");
	var i=0;
	if($('#check_all_'+id.id).is(':checked'))
	{
		$('#table_body'+id.id+' tbody :checkbox').each(function()
		{
			this.checked = true;
			add_multiselect_listitems(id,data[i],data.length,data.length);
			i++;
		});
	}
	else
	{
		$('#table_body'+id.id+' tbody :checkbox').each(function()
		{
			this.checked = false;
			add_multiselect_listitems(id,data[i],data.length,data.length);
			i++;
		});
	}
}