var st=2;
var operation_success_msg=new Array (22);
operation_success_msg[0]="Data is Saved Successfully";
operation_success_msg[1]="Data is Updated Successfully";
operation_success_msg[2]="Data is Deleted Successfully";
operation_success_msg[3]="Report is Generated Successfully";
operation_success_msg[4]="List View is Populated Successfully";

operation_success_msg[5]="Data is not Saved Successfully";
operation_success_msg[6]="Data is not Updated Successfully";
operation_success_msg[7]="Data is not Deleted Successfully";
operation_success_msg[8]="Report is not Generated Successfully";
operation_success_msg[9]="List View is not Populated Successfully";
operation_success_msg[10]="Invalid Operation";
operation_success_msg[11]="Duplicate Data Found, Please check again.";
operation_success_msg[12]="Old Password not Matching, Please check again.";
operation_success_msg[13]="Delete restricted, This Information is used in another Table.";
operation_success_msg[14]="Update restricted, This Information is used in another Table.";
operation_success_msg[15]="Database is Busy, Please wait...";
operation_success_msg[16]="This Information is already Approved. So You can't change it.";
operation_success_msg[17]="Issue Qnty Exceeds Stock Qnty.";
operation_success_msg[18]="Data is Populated Successfully";
operation_success_msg[19]="Data is Approved Successfully";
operation_success_msg[20]="Data is Un-Approved Successfully";
operation_success_msg[21]="Data is not Approved Successfully";
operation_success_msg[22]="Data is not Un-Approved Successfully";
operation_success_msg[23]="Overlapping Not Allowed, Please Check agian";
operation_success_msg[24]="Image Add is Required, Please Save The Image First.";
operation_success_msg[25]="Total input quantity over the total cut quantity not allowed.";
operation_success_msg[26]="Total output quantity over the total sewing input quantity not allowed.";
operation_success_msg[27]="Total iron quantity over the total sewing output quantity not allowed.";
operation_success_msg[28]="Total finishing quantity over the total iron quantity not allowed.";
operation_success_msg[29]="Total inspection quantity over the total finishing quantity not allowed.";
operation_success_msg[30]="Total garments quantity over the total inspection quantity not allowed.";
operation_success_msg[31]="Entry quantity can not exceed balance or total quantity.";
operation_success_msg[32]="Data is  Acknowledged Successfully";
operation_success_msg[33]="Data is Un-Acknowledged Successfully";
operation_success_msg[34]="Data is Not Acknowledged Successfully";
operation_success_msg[35]="Data is Not Un-Acknowledged Successfully";
operation_success_msg[36]="Copy Successfully";
operation_success_msg[37]="Data is not Populated";

function  showNotification(message,type='success',second = 5)
{
	Swal.fire({
		icon: type, // Set the icon to 'success'
		title: message,
		toast: true,
		position: 'top-end', // Display the toast at the top-right position
		showConfirmButton: false,
		timer: second * 1000,
		willOpen: () => {
			//console.log('Modal will open'); // Perform actions before the modal opens
		},
		didOpen: () => {
			//console.log('Modal is open'); // Perform actions after the modal opens
		},
		willClose: () => {
			//error();
		},
		didClose: () => {
			//console.log('Modal is closed'); // Perform actions after the modal closes
		}
	});
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

function show_list_view( data, action, div, path, extra_func, is_append , tabe_id ='')
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
	//console.log(`list view url : ${url}`);
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
		if(tabe_id!='')
		{
			setFilterGrid(tabe_id,-1);
		}
    })
    .catch(error => {
		showNotification(error,'error');
    	//console.log(error);
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
        showNotification(error,'error');
        //console.log(error);
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


function reset_form( forms, divs, fields, default_val, extra_func, non_refresh_ids )
{
  //alert(forms);
  // iterate over all of the inputs for the form
  // element that was passed in
	// alert(document.getElementById('Delete1').getAttribute('onclick'));
	// return;
	//default_val== "id,val*id,val*id,val"
	if (!extra_func) var extra_func="";
	if (!non_refresh_ids) var non_refresh_ids="";
	if (!default_val) var default_val="";

  if (forms.length > 0)
  {
	   forms=forms.split('*');
		for (var i=0; i<forms.length; i++)
		{
			var form_id=forms[i].split("_");
			//alert(form_id)
			var idd=$('#'+forms[i]).find('.formbutton').attr('id');
			//alert(forms[i]);
			//alert(idd);
			var fnc=document.getElementById(idd).getAttribute('onclick').split('(');
			set_button_status(0, permission, fnc[0], form_id[1]);

			non_refresh_ids_arr = non_refresh_ids.split('*');

			$('#'+forms[i]).find(':input').each(function()
			{
				if(jQuery.inArray(this.id, non_refresh_ids_arr)== -1)
				{
					var type = this.type;
					var tag = this.tagName.toLowerCase(); // normalize case
					// it's ok to reset the value attr of text inputs,
					// password inputs, and textareas
					if (type == 'text' || type == 'password' || type == 'hidden' || tag == 'textarea')
					  this.value = "";
					// checkboxes and radios need to have their checked state cleared
					// but should *not* have their 'value' changed
					else if (type == 'checkbox' || type == 'radio')
					  this.checked = false;
					// select elements need to have their 'selectedIndex' property set to -1
					// (this works for both single and multiple select elements)
					else if (type == 'select-one')
					  this.selectedIndex = 0;
					else if (type == 'hidden')
					  this.value = "";
				}
			});
		}
    }
	if (divs.length > 0)
  	{
	   divs=divs.split('*');
		for (var i=0; i<divs.length; i++)
		{
			document.getElementById(divs[i]).innerHTML="";
		}
	}
	if (fields.length > 0)
  	{

	   fields=fields.split('*');
		for (var i=0; i<fields.length; i++)
		{

			var type = document.getElementById(fields[i]).type;
			var tag = document.getElementById(fields[i]).tagName.toLowerCase(); // normalize case
			// it's ok to reset the value attr of text inputs,

			if (type == 'text' || type == 'password' || type == 'textarea')
			  document.getElementById(fields[i]).value = "";
			// checkboxes and radios need to have their checked state cleared
			// but should *not* have their 'value' changed
			else if (type == 'checkbox' || type == 'radio')
			  document.getElementById(fields[i]).checked = false;
			// select elements need to have their 'selectedIndex' property set to -1
			// (this works for both single and multiple select elements)
			else if (type == 'select-one')
			  document.getElementById(fields[i]).selectedIndex = 0;
			else if (type == 'hidden')
			  document.getElementById(fields[i]).value = "";
		}
	}
	//console.log(`default_val.length=${default_val.length}`);
	if (default_val.length > 0)
	{
		default_val=default_val.split('*');
		for (var i=0; i<default_val.length; i++)
		{
			def=default_val[i].split(',');
			if (!def[2])
				document.getElementById(def[0]).value = def[1];
			else
			{
				for (var k=1; k<=def[2]; k++)
				{
					document.getElementById(def[0]+k).value = def[1];
				}
			}

		}
	}
	eval(extra_func);
	//alert('mm')
}

function get_php_form_data( id, type, path )
{
	//console.log(id,type,path);
	// //alert(id);return;
	// ajax.requestFile = path+'.php?data=' + id + '&action=' + type;	// Specifying which file to get
	// ajax.onCompletion = eval_result;	// Specify function that will be executed after file has been found
	// ajax.runAJAX();
}
function get_form_data(data,files ='')
{
	try
	{
		const formData = new FormData();
		if(files.length > 0 )
		{
			var exp_files = files.split(',');
			for(var ex_f of exp_files)
			{
				var fileInput = document.getElementById(ex_f);
				if (fileInput.files.length > 0)
				{
					for (let i = 0; i < fileInput.files.length; i++) {
						var file = fileInput.files[i];
						formData.append('files[]', file);
					}
				}
			}
		}

		if(data.length > 0 )
		{
			var exp = data.split(",");
			for(var ex of exp)
			{
				formData.append(ex, $("#"+ex).val());
			}
		}

		return formData;
	} catch (error) {
		//console.log(`error = ${error}`);
		return "";
	}
}

function readImage(input,displayImage)
{
	if (input.files && input.files[0])
	{
		var reader = new FileReader();
		reader.onload = function(e) {
			$(`#${displayImage}`).css('display','block');
			$(`#${displayImage}`).attr('src', e.target.result);
		}
		reader.readAsDataURL(input.files[0]);
	}
}

async function populate_form_data(filter_column_name,filter_column_value,table_name,database_column_name,form_field_name,_token,others='')
{
	var return_value = -1 ;
	var url = `/populate_common_data`;
	await fetch(url,{
		method: "POST" ,
		headers: {
			'Content-Type': 'application/json',
			'X-Requested-With': 'XMLHttpRequest',
			'X-CSRF-TOKEN': _token
		},
		body: JSON.stringify({
			filter_column_name:filter_column_name,
			filter_column_value:filter_column_value,
			table_name:table_name,
			column_names:database_column_name,
			_token:_token,
			others: others
		})
	})
	.then(response => {
		if (!response.ok) {
			throw new Error('Network response was not ok');
		}
		return response.json();
	})
	.then(data => {
		if(data.code == 18)
		{
			if(database_column_name.length > 0 && form_field_name.length > 0)
			{
				var db_columns = database_column_name.split("*");
				var form_columns = form_field_name.split("*");

				for( var row_no = 0 ; row_no < Math.min(db_columns.length,form_columns.length); row_no++)
				{
					var db_col = db_columns[row_no];
					//console.log(`${form_columns[row_no]} = ${data.data[db_col]}`);
					document.getElementById(form_columns[row_no]).value = data.data[db_col];
				}
				return_value = 1 ;
				showNotification(operation_success_msg[data.code]);
			}
			if (Object.keys(data.others_data).length > 0) {
				for (var key in data.others_data) {
				  if (data.others_data.hasOwnProperty(key)) {
					var value = data.others_data[key];
					var element = document.getElementById(key);
					if (element) {
					  // Check if the element exists before setting its value
					  if (element.tagName === 'IMG') {
						// If the element is an image tag, set the src attribute
						element.src = value;
						element.style.display = 'block'; // Set display to block
					  } else {
						// For other types of elements, set the value attribute
						element.value = value;
					  }
					}
				  }
				}
			}  
		}
		else
		{
			showNotification(operation_success_msg[data.code],'error');
		}
	})
	.catch(error => {

		showNotification(error,'error');
		//console.log(error);
	});
	return return_value;
}

function save_update_delete(operation,url,request_data,column_name='',show_list_view_name='',show_list_view_div_id ='',reset_form_id='')
{
	

	fetch(url,request_data)
	.then(response => {
		if (!response.ok) {
			throw new Error('Network response was not ok');
		}
		return response.json();
	})
	.then(data => {
		showNotification(operation_success_msg[data.code]);
		if(operation < 2)
		{
			if(column_name.length > 0)
			{
				if(reset_form_id.length > 0)
				{
					reset_form(reset_form_id,'','',1);
				}
				load_php_data_to_form(data.data[column_name]);
			}
		}
		else if (operation == 2)
		{
			if(reset_form_id.length > 0)
			{
				reset_form(reset_form_id,'','',1);
			}
		}
		if(show_list_view_name.length > 0 && show_list_view_div_id.length > 0)
		{
			show_list_view(show_list_view_name,'show_common_list_view',show_list_view_div_id,'/show_common_list_view','setFilterGrid("list_view",-1)');
		}
	})
	.catch(error => {
		showNotification(error,'error');
		console.error(error);
	});
}