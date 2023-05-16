function set_button_status(is_update, permission, submit_func, btn_id, show_print)
{
    if(!show_print) var show_print="";
	permission=permission.split('_');

	if (is_update==1)   //Update Mode
	{
		 if (permission[0] == 2 )
		 {
		 	$('#save'+btn_id).removeClass('formbutton').addClass('formbutton_disabled')
			$('#save'+btn_id).attr('onclick', 'show_no_permission_msg(0)');
		 }
		 else
		 {
			 $('#save'+btn_id).removeClass('formbutton').addClass('formbutton_disabled');
			 $('#save'+btn_id).attr('onclick', 'show_button_disable_msg(0)');
		 }
		if( permission[1] == 2 )
		{
			 $('#update'+btn_id).removeClass('formbutton').addClass('formbutton_disabled');
			 $('#update'+btn_id).attr('onclick', 'show_no_permission_msg(1)');
		}
		else
		{
			 $('#update'+btn_id).removeClass('formbutton_disabled').addClass('formbutton');
			 $('#update'+btn_id).attr('onclick', submit_func+'(1)');
		}
		if( permission[2] == 2 )
		{
			 $('#Delete'+btn_id).removeClass('formbutton').addClass('formbutton_disabled');
			 $('#Delete'+btn_id).attr('onclick', 'show_no_permission_msg(2)');
		}
		else
		{
			 $('#Delete'+btn_id).removeClass('formbutton_disabled').addClass('formbutton');
			 $('#Delete'+btn_id).attr('onclick', submit_func+'(2)');
		}
		if(permission[3] == 2)
		 {
			  $('#approve'+btn_id).removeClass('formbutton').addClass('formbutton_disabled');
			  $('#approve'+btn_id).attr('onclick', 'show_no_permission_msg(3)');
		 }
		 else
		 {
			  $('#approve'+btn_id).removeClass('formbutton_disabled').addClass('formbutton');
			  $('#approve'+btn_id).attr('onclick', submit_func+'(3)');
		 }

		if( permission[4] == 2 )
		{
			 $('#Print'+btn_id).removeClass('formbutton').addClass('formbutton_disabled');
			 $('#Print').attr('onclick', 'show_no_permission_msg(4)');
		}
		else
		{
			 $('#Print'+btn_id).removeClass('formbutton_disabled').addClass('formbutton');
			 $('#Print'+btn_id).attr('onclick', submit_func+'(4)');
		}
	}
	else   //New Insert Mode
	{
		 if (permission[0] == 2 )
		 {
		 	$('#save'+btn_id).removeClass('formbutton').addClass('formbutton_disabled')
			$('#save'+btn_id).attr('onclick', 'show_no_permission_msg(0)');
		 }
		 else
		 {
			 $('#save'+btn_id).removeClass('formbutton_disabled').addClass('formbutton');
			 $('#save'+btn_id).attr('onclick', submit_func+'(0)');
		 }
		 if (permission[1] == 2 )
		 {
		 	$('#update'+btn_id).removeClass('formbutton').addClass('formbutton_disabled')
			$('#update'+btn_id).attr('onclick', 'show_no_permission_msg(1)');
		 }
		 else
		 {
			 $('#update'+btn_id).removeClass('formbutton').addClass('formbutton_disabled');
			 $('#update'+btn_id).attr('onclick', 'show_button_disable_msg(1)');
		 }
		 if (permission[2] == 2 )
		 {
		 	$('#Delete'+btn_id).removeClass('formbutton').addClass('formbutton_disabled')
			$('#Delete'+btn_id).attr('onclick', 'show_no_permission_msg(2)');
		 }
		 else
		 {
			 $('#Delete'+btn_id).removeClass('formbutton').addClass('formbutton_disabled');
			 $('#Delete'+btn_id).attr('onclick', 'show_button_disable_msg(2)');
		 }
		 if (permission[3] == 2 )
		 {
		 	$('#approve'+btn_id).removeClass('formbutton').addClass('formbutton_disabled')
			$('#approve'+btn_id).attr('onclick', 'show_no_permission_msg(3)');
		 }
		 else
		 {
			 $('#approve'+btn_id).removeClass('formbutton').addClass('formbutton_disabled');
			 $('#approve'+btn_id).attr('onclick', 'show_button_disable_msg(3)');
		 }

		 if(show_print==1)
		 {
			if( permission[4] == 2 )
			{
				 $('#Print'+btn_id).removeClass('formbutton').addClass('formbutton_disabled');
				 $('#Print').attr('onclick', 'show_no_permission_msg(4)');
			}
			else
			{
				 $('#Print'+btn_id).removeClass('formbutton_disabled').addClass('formbutton');
				 $('#Print'+btn_id).attr('onclick', submit_func+'(4)');
			}
		 }
		 else
		 {
			 if ( permission[4] == 2 )
			 {
				$('#Print'+btn_id).removeClass('formbutton').addClass('formbutton_disabled')
				$('#Print'+btn_id).attr('onclick', 'show_no_permission_msg(4)');
			 }
			 else
			 {
				 $('#Print'+btn_id).removeClass('formbutton').addClass('formbutton_disabled');
				 $('#Print'+btn_id).attr('onclick', 'show_button_disable_msg(4)');
			 }
		 }
	}
	return;
}
function show_no_permission_msg(str)
{
	alert('Ask Your admin for '+ operation[str]+' Persmission.');
}

function show_button_disable_msg(str)
{
	return false;
}

function set_date_range(mon)
{
	var year = document.getElementById('cbo_year_selection').value;

	$('.month_button_selected').removeClass('month_button_selected').addClass('month_button');
	if (mon.substr(0,1)=="0") id_id=mon.replace("0",""); else id_id=mon;
	$('#btn_'+id_id).removeClass('month_button').addClass('month_button_selected');

	var currentTime = new Date();
	var month = currentTime.getMonth() + 1;
	var day = currentTime.getDate();
	//var year = currentTime.getFullYear();

	var start_date="01" + "-" + mon  + "-" + year;
	var to_date=daysInMonth(mon,year) + "-" + mon  + "-" + year;

	document.getElementById('txt_date_from').value=start_date;
	document.getElementById('txt_date_to').value=to_date;
}

function daysInMonth( month, year )
{
	return new Date(year, month, 0).getDate();
}

function set_button_status(is_update, permission, submit_func, btn_id, show_print)
{
    if(!show_print) var show_print="";
	permission=permission.split('_');

	if (is_update==1)   //Update Mode
	{
		 if (permission[0] == 2 )
		 {
		 	$('#save'+btn_id).removeClass('formbutton').addClass('formbutton_disabled')
			$('#save'+btn_id).attr('onclick', 'show_no_permission_msg(0)');
		 }
		 else
		 {
			 $('#save'+btn_id).removeClass('formbutton').addClass('formbutton_disabled');
			 $('#save'+btn_id).attr('onclick', 'show_button_disable_msg(0)');
		 }
		if( permission[1] == 2 )
		{
			 $('#update'+btn_id).removeClass('formbutton').addClass('formbutton_disabled');
			 $('#update'+btn_id).attr('onclick', 'show_no_permission_msg(1)');
		}
		else
		{
			 $('#update'+btn_id).removeClass('formbutton_disabled').addClass('formbutton');
			 $('#update'+btn_id).attr('onclick', submit_func+'(1)');
		}
		if( permission[2] == 2 )
		{
			 $('#Delete'+btn_id).removeClass('formbutton').addClass('formbutton_disabled');
			 $('#Delete'+btn_id).attr('onclick', 'show_no_permission_msg(2)');
		}
		else
		{
			 $('#Delete'+btn_id).removeClass('formbutton_disabled').addClass('formbutton');
			 $('#Delete'+btn_id).attr('onclick', submit_func+'(2)');
		}
		if(permission[3] == 2)
		 {
			  $('#approve'+btn_id).removeClass('formbutton').addClass('formbutton_disabled');
			  $('#approve'+btn_id).attr('onclick', 'show_no_permission_msg(3)');
		 }
		 else
		 {
			  $('#approve'+btn_id).removeClass('formbutton_disabled').addClass('formbutton');
			  $('#approve'+btn_id).attr('onclick', submit_func+'(3)');
		 }

		if( permission[4] == 2 )
		{
			 $('#Print'+btn_id).removeClass('formbutton').addClass('formbutton_disabled');
			 $('#Print').attr('onclick', 'show_no_permission_msg(4)');
		}
		else
		{
			 $('#Print'+btn_id).removeClass('formbutton_disabled').addClass('formbutton');
			 $('#Print'+btn_id).attr('onclick', submit_func+'(4)');
		}
	}
	else   //New Insert Mode
	{
		 if (permission[0] == 2 )
		 {
		 	$('#save'+btn_id).removeClass('formbutton').addClass('formbutton_disabled')
			$('#save'+btn_id).attr('onclick', 'show_no_permission_msg(0)');
		 }
		 else
		 {
			 $('#save'+btn_id).removeClass('formbutton_disabled').addClass('formbutton');
			 $('#save'+btn_id).attr('onclick', submit_func+'(0)');
		 }
		 if (permission[1] == 2 )
		 {
		 	$('#update'+btn_id).removeClass('formbutton').addClass('formbutton_disabled')
			$('#update'+btn_id).attr('onclick', 'show_no_permission_msg(1)');
		 }
		 else
		 {
			 $('#update'+btn_id).removeClass('formbutton').addClass('formbutton_disabled');
			 $('#update'+btn_id).attr('onclick', 'show_button_disable_msg(1)');
		 }
		 if (permission[2] == 2 )
		 {
		 	$('#Delete'+btn_id).removeClass('formbutton').addClass('formbutton_disabled')
			$('#Delete'+btn_id).attr('onclick', 'show_no_permission_msg(2)');
		 }
		 else
		 {
			 $('#Delete'+btn_id).removeClass('formbutton').addClass('formbutton_disabled');
			 $('#Delete'+btn_id).attr('onclick', 'show_button_disable_msg(2)');
		 }
		 if (permission[3] == 2 )
		 {
		 	$('#approve'+btn_id).removeClass('formbutton').addClass('formbutton_disabled')
			$('#approve'+btn_id).attr('onclick', 'show_no_permission_msg(3)');
		 }
		 else
		 {
			 $('#approve'+btn_id).removeClass('formbutton').addClass('formbutton_disabled');
			 $('#approve'+btn_id).attr('onclick', 'show_button_disable_msg(3)');
		 }

		 if(show_print==1)
		 {
			if( permission[4] == 2 )
			{
				 $('#Print'+btn_id).removeClass('formbutton').addClass('formbutton_disabled');
				 $('#Print').attr('onclick', 'show_no_permission_msg(4)');
			}
			else
			{
				 $('#Print'+btn_id).removeClass('formbutton_disabled').addClass('formbutton');
				 $('#Print'+btn_id).attr('onclick', submit_func+'(4)');
			}
		 }
		 else
		 {
			 if ( permission[4] == 2 )
			 {
				$('#Print'+btn_id).removeClass('formbutton').addClass('formbutton_disabled')
				$('#Print'+btn_id).attr('onclick', 'show_no_permission_msg(4)');
			 }
			 else
			 {
				 $('#Print'+btn_id).removeClass('formbutton').addClass('formbutton_disabled');
				 $('#Print'+btn_id).attr('onclick', 'show_button_disable_msg(4)');
			 }
		 }
	}
	return;
}

function form_validation(control,msg_text)
{
  // iterate over all of the inputs for the form
  // element that was passed in
 // alert(control);
 //alert(parent.document.getElementById('messagebox_main').innerHTML);

	//parent.document.getElementById('messagebox_main').innerHTML=;
	//$('#messagebox_main', window.parent.document).html("sumon");

  control=control.split("*");
  msg_text=msg_text.split("*");
  var bgcolor='-moz-linear-gradient(bottom, rgb(254,151,174) 0%, rgb(255,255,255) 10%, rgb(254,151,174) 96%)';
  var new_elem="";
  for (var i=0; i<control.length; i++)
  {
	  	const el = document.querySelector('#'+control[i]);
		if(!el)
		{
			console.log('Id name: ' + control[i] + ' not found');
		}

	  var type = document.getElementById(control[i]).type;
		var tag = document.getElementById(control[i]).tagName;
		document.getElementById(control[i]).style.backgroundImage="";
		var cls=$('#'+control[i]).attr('class');

		if( cls=="text_boxes_numeric" ) //if ( type == 'text' || type == 'password' || type == 'textarea' )
		{
			if (trim(document.getElementById(control[i]).value)=="" || (trim(document.getElementById(control[i]).value)*1)==0)
			{
				 document.getElementById(control[i]).focus();
				 document.getElementById(control[i]).style.backgroundImage=bgcolor;
				 $('#messagebox_main', window.parent.document).fadeTo(100,1,function() //start fading the messagebox
				 {
					$(this).html('Please Fill up '+msg_text[i]+' field Value').removeClass('messagebox').addClass('messagebox_error').fadeOut(2500);
				 });
				 return 0;
			}
		}

		if ( type == 'text' || type == 'password' || type == 'textarea' )
		{
			if (trim(document.getElementById(control[i]).value)=="")
			{
				 document.getElementById(control[i]).focus();
				 document.getElementById(control[i]).style.backgroundImage=bgcolor;
				 $('#messagebox_main', window.parent.document).fadeTo(100,1,function() //start fading the messagebox
				 {
					$(this).html('Please Fill up '+msg_text[i]+' field Value').removeClass('messagebox').addClass('messagebox_error').fadeOut(2500);
				 });
				 return 0;
			}
		}
		else if (type == 'select-one' || type=='select' )
		{
			//alert(control[i]);
			 if ( trim(document.getElementById(control[i]).value)==0)
			 {
				 document.getElementById(control[i]).focus();
				 document.getElementById(control[i]).style.backgroundImage=bgcolor;
				 $('#messagebox_main', window.parent.document).fadeTo(100,1,function() //start fading the messagebox
				 {
					$(this).html('Please Select  '+msg_text[i]+' field Value').removeClass('messagebox').addClass('messagebox_error').fadeOut(2500);

				 });
				 return 0;
			 }
		}
		else if (type == 'checkbox' || type == 'radio')
		{
			 document.getElementById(control[i]).style.backgroundImage=bgcolor;
			 if (new_elem=="") new_elem=control[i]; else new_elem=new_elem+","+control[i];
		}
		else if (type == 'hidden' )
		{
			if(trim(document.getElementById(control[i]).value)=='')
			{
				if(msg_text[i]!='')
				{
					$('#messagebox_main', window.parent.document).fadeTo(100,1,function() //start fading the messagebox
					 {
						alert('Please Fill up or Select '+msg_text[i]+' field Value');
						$(this).html('Please Fill up or Select '+msg_text[i]+' field Value').removeClass('messagebox').addClass('messagebox_error').fadeOut(2500);

					 });
					 return 0;
				}
				else
				{
					$('#messagebox_main', window.parent.document).fadeTo(100,1,function() //start fading the messagebox
					 {
						$(this).html('Please fill up master field Value').removeClass('messagebox').addClass('messagebox_error').fadeOut(2500);

					 });
					 return 0;

				}

			}
		}

  }
  return 1;

}

function get_submitted_variables( flds )
{
     var fld_data='';
    flds=flds.split('*');
    for (var i=0; i< flds.length; i++)
    {
        fld_data=fld_data+'var '+flds[i]+'=  escape(document.getElementById("'+flds[i]+'").value);\n';
    }
    return fld_data;
}

function get_submitted_data_string( flds, path="", session="" )
{
    var fld_data='';
    flds=flds.split('*');
    for (var i=0; i< flds.length; i++)
    {
        var sp = "";
        if(fld_data.length > 0) sp = ",";
        const el = document.querySelector('#'+flds[i]);
        if (!el) {
            console.log('Id name: ' + flds[i] + ' not found');
        }
        if(document.getElementById(flds[i]).className=="datepicker hasDatepicker")
        {
            fld_data=fld_data+sp+flds[i]+":'"+  change_date_format(trim(document.getElementById(flds[i]).value),path)+"'";
        }
        else fld_data=fld_data+sp+flds[i]+":'"+  encodeURIComponent(trim(document.getElementById(flds[i]).value))+"'";///encodeURIComponent added my monzu, date 01/07/2017
   }
   return (fld_data);
}

function change_date_format(date, path="", new_format, new_sep)
{
	//This function will return newly formatted date String

	var month_array=Array();
	month_array[1]="Jan";
	month_array[2]="Feb";
	month_array[3]="Mar";
	month_array[4]="Apr";
	month_array[5]="May";
	month_array[6]="Jun";
	month_array[7]="Jul";
	month_array[8]="Aug";
	month_array[9]="Sep";
	month_array[10]="Oct";
	month_array[11]="Nov";
	month_array[12]="Dec";

	if(date=="") return '';
	if ( !path) var path="";
	if ( !new_format) var new_format="yyyy-mm-dd";
	if ( !new_sep) var new_sep="-";
	var ddd=date.split("-");
	if(db_type==0)
		date=ddd[2]+"-"+ddd[1]+"-"+ddd[0];
	 else if(db_type==1)
	 	date=ddd[2]+"-"+ddd[1]+"-"+ddd[0];
	else if(db_type==2)
		date=ddd[0]+"-"+month_array[parseInt(ddd[1])]+"-"+ddd[2];
	return( date);
}

function trim( stringToTrim ) {
	return stringToTrim.replace( /^\s+|\s+$/g, "" );
}

function ltrim( stringToTrim ) {
	return stringToTrim.replace( /^\s+/, "" );
}

function rtrim( stringToTrim ) {
	return stringToTrim.replace( /\s+$/, "" );
}

function show_list_view( data, action, div, path, extra_func, is_append )
{
	if (!extra_func) var extra_func="";
	if (!data) var data="0";
	if (!is_append) var is_append="";
	//freeze_window(1);
	//alert(data.length);
	document.getElementById(div).innerHTML='<span style="font-size:24px; font-weight:bold; color:#FF0000; margin-top:10px">Please wait, Data is Loading...</span>';
	if( trim(data).length == 0 ) {
		document.getElementById(div).innerHTML = "";
		return;
	}

    var base_url = getBaseUrl();

    var url = `${base_url}${path}?data=${data}&action=${action}`;
    fetch(url, {
    method: 'GET',
    headers: {
        'Content-Type': 'text/plain',
        'Access-Control-Allow-Origin': '*'
    }
    })
    .then(response => response.text())
    .then(html => {
    if (is_append != 1) {
        document.getElementById(div).innerHTML = html;
    } else {
        document.getElementById(div).innerHTML += html;
    }
    eval(extra_func);
    })
    .catch(error => {
    console.log(error);
    });


}

function set_all_onclick()
{
	// To Change Background Color of Validated Field\

	jQuery(".text_boxes").click(function() {
	    var contentPanelId = jQuery(this).attr("id");
	    if(document.getElementById(contentPanelId).style.backgroundColor!="")
			document.getElementById(contentPanelId).style.backgroundColor="";

	});

	 jQuery(".text_area").click(function() {
	    var contentPanelId = jQuery(this).attr("id");
	    if(document.getElementById(contentPanelId).style.backgroundColor!="")
			document.getElementById(contentPanelId).style.backgroundColor="";

	});
	jQuery(".combo_boxes").click(function() {
	    var contentPanelId = jQuery(this).attr("id");
	    if(document.getElementById(contentPanelId).style.backgroundColor!="")
			document.getElementById(contentPanelId).style.backgroundColor="";

	});
	jQuery(".text_boxes_numeric").click(function() {
	    var contentPanelId = jQuery(this).attr("id");
	    if(document.getElementById(contentPanelId).style.backgroundColor!="")
			document.getElementById(contentPanelId).style.backgroundColor="";

	});
	jQuery(".datepicker").click(function() {
	    var contentPanelId = jQuery(this).attr("id");
	    if(document.getElementById(contentPanelId).style.backgroundColor!="")
			document.getElementById(contentPanelId).style.backgroundColor="";
	});
   // To Change Background Color of Validated Field ends


	jQuery(".text_boxes_numeric").keypress(function(e) {

		var c = String.fromCharCode(e.which);
	 	var evt = (e) ? e : window.event;
	    var key = (evt.keyCode) ? evt.keyCode : evt.which;
		if(key != null) key = parseInt(key, 10);
		var allowed = '1234567890.'; // ~ replace of Hash(#)
			if (isUserFriendlyChar(key)) return true
			else if (key != 8 && key !=0 && allowed.indexOf(c) < 0)
				return false;
			else if (!numeric_valid( $(this).attr('id'), 0))
				return false;
	});

	jQuery(".text_boxes_numeric").blur(function(e) {
		numeric_valid( $(this).attr('id'), 1)
	});

	function numeric_valid( id, from)
	{
		var txt=$('#'+id).val();//.split('.');
		var dotposl=txt.lastIndexOf(".");
		var dotposf=txt.indexOf(".");
		if (dotposl!=dotposf)
		{
			var txt_d=$('#'+id).val().substr(0,dotposl);
			$('#'+id).val(txt_d);//alert(txt_d);
			numeric_valid( id, from)
		}
		else return true;
	}

	function isUserFriendlyChar(val) {
	      // Backspace, Tab, Enter, Insert, and Delete
	      if(val == 8 || val == 9 || val == 13 || val == 46 )// || val == 45 Insert
	        return true;
		// Ctrl, Alt, CapsLock, Home, End, and Arrows
	      if((val > 16 && val < 21) || (val > 34 && val < 41))
	        return true;
		// The rest
	      return false;
	}
 	//Numeric Text Box Validation Ends

	// Special Character Validation
	jQuery(".text_boxes").keypress(function(e) {
	     var c = String.fromCharCode(e.which);
		 var allowed = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890.-,%@!/\<>?+[]{};:# '; // ~ replace of Hash(#)()
		 if (e.which != 8 && e.which !=0 && allowed.indexOf(c) < 0)
		  	return false;

	});


  	$('.text_boxes').blur(function(e) {
	    var target = e.target || e.srcElement;
   		document.getElementById(target.id).value=document.getElementById(target.id).value.replace("#","~");
	});


	jQuery(".text_area").keypress(function(e) {
	     var c = String.fromCharCode(e.which);
		 var allowed = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890.-,%@!/\<>?+[]{};:# '; // ~ replace of Hash(#)()
		 if (e.which != 8 && e.which !=0 && allowed.indexOf(c) < 0)
		  	return false;
	});

  	$('.text_area').blur(function(e) {
	    var target = e.target || e.srcElement;
   		if (document.getElementById(target.id).value!="") document.getElementById(target.id).value=document.getElementById(target.id).value.replace("#","~");
	});

 	// Special Character Validation Ends

	 															 // Global Date Picker Initialisaton
	$( ".datepicker" ).datepicker({
					dateFormat: 'dd-mm-yy',
					changeMonth: true,
					changeYear: true
				});

	$('.timepicker').timepicker({
			H: true
	});
	 // Datapickker ENds


	if(isMobile.any()) {  // 09-03-2015
	   //alert("This is a Mobile Device");
	   $(".text_boxes").each(function( index ) {
			 var ttl=$(this).attr('onDblClick');
			 if(!ttl) var ttl=""; else ttl=ttl+";"
			$(this).attr('onClick',ttl);
		});

		$(".text_boxes_numeric").each(function( index ) {
			 var ttl=$(this).attr('onDblClick');
			 if(!ttl) var ttl=""; else ttl=ttl+";"
			$(this).attr('onClick',ttl);
		});
	}

	$( ".combo_boxes" ).each(function( index ) {
		/*if($('#'+this.id+' option').length==2)
		{
			if($('#'+this.id+' option:first').val()==0)
			{
				$('#'+this.id).val($('#'+this.id+' option:last').val());
				//alert($('#'+this.id+' option:last').val());
				eval( $('#'+this.id).attr('onchange') );
			}
		}
		else if($('#'+this.id+' option').length==1)
		{
			$('#'+this.id).val($('#'+this.id+' option:last').val());
			eval($('#'+this.id).attr('onchange'));
		}

		if($('#'+this.id+'').val!=0)
		{
			//$('#'+this.id).val($('#'+this.id+' option:last').val());
			eval($('#'+this.id).attr('onchange'));
		}*/
	});
}



function searchTable(tableId, inputFieldId, footer_table_id = '', columnPositions = '', operations = '')
{
    let input = document.getElementById(inputFieldId);
    let filter = input.value.toUpperCase();
    let table = document.getElementById(tableId);
    let rows = [...table.getElementsByTagName('tr')];
    let originalRows = Array.from(rows); // Store a copy of the original rows

    // Initialize result object with keys for each column position
    let result = {};
    if (columnPositions) {
      columnPositions.split(',').forEach((col) => {
        result[col] = 0;
      });
    }

    // Filter the rows based on the search value
    let filteredRows = originalRows.filter((row) => {
      let cells = row.getElementsByTagName('td');
      for (let i = 0; i < cells.length; i++) {
        let cell = cells[i];
        if (cell.innerHTML.toUpperCase().indexOf(filter) > -1) {
          return true;
        }
      }
      return false;
    });

    // Update the table with the filtered rows
    rows.forEach((row) => {
      row.style.display = 'none';
    });
    filteredRows.forEach((row) => {
      row.style.display = '';
    });

    // Loop through each specified column position and apply the requested operation
    if (columnPositions) {
      filteredRows.forEach((row) => {
        let cells = row.getElementsByTagName('td');
        columnPositions.split(',').forEach((col, idx) => {
          let cell = cells[col];
          if (cell) {
            let cellValue = parseFloat(cell.innerHTML);
            if (operations[idx] === 'sum') {
              result[col] += cellValue;
            } else if (operations[idx] === 'mul') {
              result[col] *= cellValue;
            } else if (operations[idx] === 'sub') {
              result[col] -= cellValue;
            } else if (operations[idx] === 'div') {
              result[col] /= cellValue;
            }
          }
        });
      });
    }

    // Update the footer cells with the calculated values
    if (footer_table_id && columnPositions) {
      let columnPositionsArr = columnPositions.split(',');
      let tfoot = document.getElementById(footer_table_id).getElementsByTagName('tfoot')[0];
      let tfootRow = tfoot.getElementsByTagName('tr')[0];
      for (let i = 0; i < columnPositionsArr.length; i++) {
        let colIndex = columnPositionsArr[i];
        let tfootCell = tfootRow.getElementsByTagName('td')[colIndex];
        tfootCell.innerHTML = result[i];
      }
    }
}

function searchTableWithRowspan(tableId, inputFieldId, footer_table_id = '', columnPositions = '', operations = '') {
    let input = document.getElementById(inputFieldId);
    let filter = input.value.toUpperCase();
    let table = document.getElementById(tableId);
    let rows = table.getElementsByTagName('tr');
    let displayedRows = [];
    let result = {};

    // Initialize result object with keys for each column position
    if (columnPositions) {
      columnPositions.split(',').forEach((col) => {
        result[col] = 0;
      });
    }

    // Iterate through the rows, skipping hidden rows due to rowspan
    for (let i = 0; i < rows.length; i++) {
      let row = rows[i];
      let cells = row.getElementsByTagName('td');

      // Check if any of the cells in the row match the filter
      let rowMatchesFilter = false;
      for (let j = 0; j < cells.length; j++) {
        let cell = cells[j];
        let cellText = cell.innerHTML.toUpperCase();
        if (cellText.indexOf(filter) > -1) {
          rowMatchesFilter = true;
          break;
        }
      }

      if (rowMatchesFilter) {
        displayedRows.push(row);

        // Loop through each specified column position and apply the requested operation
        if (columnPositions) {
          columnPositions.split(',').forEach((col, idx) => {
            let cell = cells[col];
            if (cell) {
              let cellValue = parseFloat(cell.innerHTML);
              if (operations[idx] === 'sum') {
                result[col] += cellValue;
              } else if (operations[idx] === 'mul') {
                result[col] *= cellValue;
              } else if (operations[idx] === 'sub') {
                result[col] -= cellValue;
              } else if (operations[idx] === 'div') {
                result[col] /= cellValue;
              }
            }
          });
        }
      } else {
        row.style.display = 'none';

        // Adjust row index for rowspans
        if (row.cells[0].rowSpan > 1) {
          for (let j = 1; j < row.cells[0].rowSpan; j++) {
            rows[i + j].style.display = 'none';
          }
        }
      }
    }

    // Update the displayed rows with appropriate styles
    displayedRows.forEach((row) => {
      row.style.display = '';
    });

    // Update the footer cells with the calculated values
    if (columnPositions && footer_table_id) {
      let columnPositionsArr = columnPositions.split(',');
      let tfoot = document.getElementById(footer_table_id).getElementsByTagName('tfoot')[0];
      let tfootRow = tfoot.getElementsByTagName('tr')[0];
      for (let i = 0; i < columnPositionsArr.length; i++) {
        let colIndex = columnPositionsArr[i];
        let tfootCell = tfootRow.getElementsByTagName('td')[colIndex];
        tfootCell.innerHTML = result[i];
      }
    }
}


function load_drop_down( plink, data, action, container ) {
	//alert(data);
    var url = `/${plink}?data=${data}&action=${action}`;
    fetch(url)
    .then(response => response.text())
    .then(html => {
        document.getElementById(container).innerHTML = html;
    })
    .catch(error => {
        //toastr.error(error, 'Oops!');
        console.log(error);
    });
}

function getBaseUrl()
{
    const protocol = window.location.protocol;
    const hostname = window.location.hostname;
    const port = window.location.port;
    const isDefaultPort = (protocol === 'http:' && port === '80') || (protocol === 'https:' && port === '443');

    const BASE_URL = isDefaultPort ? `${protocol}//${hostname}` : `${protocol}//${hostname}:${port}`;
    return BASE_URL;
}







