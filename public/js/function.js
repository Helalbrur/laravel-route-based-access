//HTML search
var st=4;//1=Exact,2=StartsWith,3=EndsWith,4=Contains 
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



var quotes_msg=new Array (50);
quotes_msg[0]="";
quotes_msg[1]="Never tell your problems to anyone...20% don't care and the other 80% are glad you have them --Lou Holtz ";
quotes_msg[2]="Be who you are and say what you feel because those who mind don't matter and those who matter don't mind --Dr. Seuss ";
quotes_msg[3]="Advice is what we ask for when we already know the answer but wish we did not --Erica Jong ";
quotes_msg[4]="Work like you don't need the money, love like you've never been hurt and dance like no one is watching --Randall G Leighton ";
quotes_msg[5]="Glory is fleeting, but obscurity is forever.- Napoleon Bonaparte";
quotes_msg[6]="Victory goes to the player who makes the next-to-last mistake.- Chessmaster Savielly Grigorievitch Tartakower";
quotes_msg[7]="Don't be so humble - you are not that great.- Golda Meir";
quotes_msg[8]="You can avoid reality, but you cannot avoid the consequences of avoiding reality.- Ayn Rand";
quotes_msg[9]="Nothing in the world is more dangerous than sincere ignorance and conscientious stupidity - Martin Luther King Jr.";
quotes_msg[10]="Happiness equals reality minus expectations.- Tom Magliozzi";
quotes_msg[11]="The only difference between I and a madman is that I'm not mad.- Salvador Dali";
quotes_msg[12]="Be the change that you wish to see in the world.― Mahatma Gandhi";
quotes_msg[13]="When one door closes, another opens; but we often look so long and so regretfully upon the closed door that we do not see the one that has opened for us. - Alexander Graham Bell";
quotes_msg[14]="Challenges are what make life interesting and overcoming them is what makes life meaningful. – Joshua J. Marine";
quotes_msg[15]="Happiness cannot be traveled to, owned, earned, or worn. It is the spiritual experience of living every minute with love, grace & gratitude. – Denis Waitley";
quotes_msg[16]="In order to succeed, your desire for success should be greater than your fear of failure. – Bill Cosby";
quotes_msg[17]="I am thankful for all of those who said NO to me. Its because of them I’m doing it myself.– Albert Einstein";
quotes_msg[18]="The only way to do great work is to love what you do. If you haven’t found it yet, keep looking. Don’t settle. – Steve Jobs";
quotes_msg[19]="The best revenge is massive success. – Frank Sinatra";
quotes_msg[20]="In the end, it's not going to matter how many breaths you took, but how many moments took your breath away. --shing xiong ";


function show_msg( msg )
{
	 $('#messagebox_main', window.parent.document).fadeTo(100,1,function() //start fading the messagebox
	 {
		$('#messagebox_main', window.parent.document).html( operation_success_msg[trim(msg)] ).removeClass('messagebox').addClass('messagebox_error').fadeOut(5500);
	 });

}


function isNumber (o) {
  return ! isNaN (o-0) && o !== null && o.replace(/^\s\s*/, '') !== "" && o !== false;
}

var mytime=0;
var isFrozen = false; // Flag to check if freeze_window is already running
function freeze_window(msg)
{
	if (isFrozen) return; // If already running, do nothing
	if ($('#mask').is(':visible') || $('.window').is(':visible')) {
        return;
    }

    isFrozen = true; // Set flag to true
	release_freezing();
	var sdf=Math.floor(Math.random()*(19-1+1)+1);
	document.getElementById('msg_text').innerHTML=quotes_msg[sdf];

	var id = '#dialog';
	//Get the screen height and width
	var maskHeight = $(document).height();
	var maskWidth = $(window).width();
	//Set height and width to mask to fill up the whole screen
	$('#mask').css({'width':maskWidth,'height':maskHeight});
	$('#dialog').css({'height':150});

	//transition effect
	$('#mask').fadeIn(0);
	$('#mask').fadeTo("slow",0.8);
	//Get the window height and width
	var winH = $(window).height();
	var winW = $(window).width();
	//Set the popup window to center
	$(id).css('top',  winH/2-$(id).height()/2);
	$(id).css('left', winW/2-$(id).width()/2);
	document.getElementById("msg").innerHTML=0;
	var time=0;
	document.getElementById("msg").innerHTML=0;
 	mytime=setInterval('count_process_time()',5000); //document.getElementById("msg").innerHTML
	//transition effect
	$(id).fadeIn(0);
}

function count_process_time()
{
	document.getElementById('msg').innerHTML=(document.getElementById('msg').innerHTML*1)+5;
	var vmax=20; var vmin=1;
	var smsg=Math.floor(Math.random()*(vmax-vmin+1)+vmin); //Math.floor(Math.random() * 6) + 1
	document.getElementById('msg_text').innerHTML=quotes_msg[smsg];
}

function release_freezing()
{

	$('#mask, .window').hide();
	 // Check if mask and window are currently visible before hiding
	if ($('#mask').is(':visible') || $('.window').is(':visible')) {
        $('#mask, .window').hide();
    }

	clearInterval(mytime);
	isFrozen = false; // Reset flag when freezing is released
}

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
function set_button_status(is_update, permission, submit_func, btn_id, show_print,is_single_button=0)
{
    if(!show_print) var show_print="";
	permission=permission.split('_');
	//console.log(`permission=${permission} , is_update = ${is_update} , btn_id = ${btn_id}`)

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
		if(is_single_button == 0)
		{
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

		if(is_single_button == 0)
		{
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

function form_validation(control,msg_text)
{
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

		if ( type == 'text' || type == 'password' || type == 'textarea' || type == 'email' )
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

function show_list_view( data, action, div, path, extra_func, is_append , tabe_id ='',param ='')
{
	freeze_window(6);
	if (!extra_func) var extra_func="";
	if (!data) var data="0";
	if (!is_append) var is_append="";
	document.getElementById(div).innerHTML='<span style="font-size:24px; font-weight:bold; color:#FF0000; margin-top:10px">Please wait, Data is Loading...</span>';
	if( trim(data).length == 0 ) {
		document.getElementById(div).innerHTML = "";
		return;
	}

    var base_url = getBaseUrl();

    var url = `${base_url}${path}?data=${data}&action=${action}&param=${param}`;
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
		release_freezing();
    })
    .catch(error => {
		showNotification(error,'error');
    	release_freezing();
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


	if(isMobile.any()) {  
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

function load_drop_down( plink, data, action, container , callback = "" )
{
    var url = `/${plink}?data=${data}&action=${action}`;
    fetch(url)
    .then(response => response.text())
    .then(html => {
        document.getElementById(container).innerHTML = html;
		if(typeof callback === "function")
		{
			// Call the callback function
			callback();
		}
		$('.select2, select[id^="cbo"]').select2();
    })
    .catch(error => {
        showNotification(error,'error');
        if(typeof callback === "function")
		{
			// Call the callback function
			callback();
		}
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

function reset_form( forms, divs, fields, default_val, extra_func, non_refresh_ids)
{
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
			//console.log(`idd=${idd}`);
			//console.log(`permission=${permission}`);
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
					{
						$(this).val('').trigger('change'); // Reset Select2
						this.selectedIndex = 0;
					}
					 
					else if (type == 'hidden')
					  this.value = "";
				}
			});
			$('#' + forms[i]).find('img').each(function() {
				$(this).css('display', 'none');
			});
			$('#' + forms[i]).find(':file').each(function() {
				$(this).val(''); // Clear the value of the input file element
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
		if (files.length > 0)
		{
			var exp_files = files.split(',');
			for (var ex_f of exp_files)
			{
				var fileInput = document.getElementById(ex_f);
				if (fileInput.files.length > 0)
				{
					for (let i = 0; i < fileInput.files.length; i++)
					{
						var file = fileInput.files[i];
						formData.append('files[]', file);
						//console.log(`file=${file}`);
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

async function populate_form_data(filter_column_name,filter_column_value,table_name,database_column_name,form_field_name,_token,others='',multi_select_column ='',extra_function_on_chage_column='')
{
	freeze_window(7);
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

				if(multi_select_column.length > 0)
				{
					var multi_select_count = multi_select_column.split("*");
					var multi_select_value = [];
					for(var cn = 0; cn < multi_select_count.length; cn++)
					{
						multi_select_value.push(multi_select_count[cn]);
					}
				}

				for( var row_no = 0 ; row_no < Math.min(db_columns.length,form_columns.length); row_no++)
				{
					var db_col = db_columns[row_no];
					//console.log(`${form_columns[row_no]} = ${data.data[db_col]}`);
					var element = document.getElementById(form_columns[row_no]);
					if (element)
					{
						// Check if element has class 'select2' or ID starts with 'cbo'
						if (($(element).hasClass('select2')  || element.id.startsWith('cbo')) && $(element).data('select2') ) {
							// Handle multi-select or single-select based on value format
							var selectedValues = data.data[db_col];
        
							// Check if selectedValues is a string and contains a comma (for multi-select)
							if (typeof selectedValues === 'string' && selectedValues.includes(',')) {
								selectedValues = selectedValues.split(",");  // Split the comma-separated values
								console.log('Setting selected values:', selectedValues);
								
							} 

							$(element).select2('destroy').val(selectedValues).select2();
							
						} else {
							// For single select or other fields, just set the value directly
							element.value = data.data[db_col];
						}

						if(multi_select_column.length > 0)
						{
							if(multi_select_value.includes(form_columns[row_no]))
							{
								var nulti_index = multi_select_value.indexOf(form_columns[row_no]);
								multi_select_value[nulti_index] = data.data[db_col];
							}
						}
						if(extra_function_on_chage_column.length > 0)
						{
							var extra_function_on_chage_column_explod = extra_function_on_chage_column.split("**");
							
							extra_function_on_chage_column_explod.forEach( (extra_function_on_chage_column_value)=>{
								var extra_function_on_chage_column_value_explod = extra_function_on_chage_column_value.split("*");
								if(extra_function_on_chage_column_value_explod[0] == form_columns[row_no])
								{
									var code = extra_function_on_chage_column_value_explod[1];
									eval(code);
								}
							})
						}
					}
					else
					{
						throw new Error(`${form_columns[row_no]} not found.`);
					}
				}
				return_value = 1 ;
				if(multi_select_column.length > 0)
				{
					var multi_select_arr = [];
					for(var cn = 0; cn < multi_select_count.length; cn++)
					{
						multi_select_arr.push(0);
					}
					var multi_select_str = multi_select_arr.join("*");
					var multi_select_value_str = multi_select_value.join("*");
					set_multiselect(multi_select_column,multi_select_str,1,multi_select_value_str,multi_select_str,'');
				}
				//showNotification(operation_success_msg[data.code],'info',2);
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
					else
					{
						throw new Error(`${key} not found.`);
					}
				  }
				}
			} 
		}
		else
		{
			showNotification(operation_success_msg[data.code],'error');
		}
		return data;
	})
	.then(data=>{
		if(extra_function_on_chage_column.length > 0)
		{
			var extra_function_on_chage_column_explod = extra_function_on_chage_column.split("**");
			if(database_column_name.length > 0 && form_field_name.length > 0)
			{
				var db_columns = database_column_name.split("*");
				var form_columns = form_field_name.split("*");
				for( var row_no = 0 ; row_no < Math.min(db_columns.length,form_columns.length); row_no++)
				{
					var db_col = db_columns[row_no];
					var element = document.getElementById(form_columns[row_no]);
					if (element)
					{
						extra_function_on_chage_column_explod.forEach( (extra_function_on_chage_column_value)=>{
							var extra_function_on_chage_column_value_explod = extra_function_on_chage_column_value.split("*");
							if(extra_function_on_chage_column_value_explod[0] == form_columns[row_no])
							{
								$(`#${form_columns[row_no]}`).val(data.data[db_col]);
								console.log(`${form_columns[row_no]}=${data.data[db_col]}`);
							}
						})
					}
					
				}
			}
		}
		release_freezing();
	})
	.catch(error => {

		showNotification(error,'warning');
		release_freezing();
	});
	return return_value;
}

function save_update_delete(operation,url,request_data,column_name='',show_list_view_name='',show_list_view_div_id ='',reset_form_id='')
{
	freeze_window(operation);
	fetch(url,request_data)
	.then(response => {
		if (!response.ok) {
			return response.json().then(errorData => {
				throw { status: response.status, data: errorData };
			});
		}
		return response.json();
	})
	.then(data => {
		console.log(`data=${data}`);
		
		if(data.code == 10)
		{
			
			if(data.hasOwnProperty("message") && data.message.length > 0)
			{
				showNotification(operation_success_msg[data.message],'error');
			}
			else
			{
				showNotification(operation_success_msg[data.code],'error');
			}
			
			return;
		}
		showNotification(operation_success_msg[data.code]);
		if(data.code < 2)
		{
			if(reset_form_id.length > 0)
			{
				reset_form(reset_form_id,'','',1);
			}
			if(column_name.length > 0 && data.data.length > 0)
			{
				
				load_php_data_to_form(data.data[column_name]);
			}
		}
		else if (data.code == 2)
		{
			if(reset_form_id.length > 0)
			{
				//console.log(`reset_form_id=${reset_form_id}`);
				reset_form(reset_form_id,'','',1);
			}
		}
		if(show_list_view_name.length > 0 && show_list_view_div_id.length > 0)
		{
			if(reset_form_id.length > 0)
			{
				reset_form(reset_form_id,'','',1);
			}
			show_list_view(show_list_view_name,'show_common_list_view',show_list_view_div_id,'/show_common_list_view','setFilterGrid("list_view",-1)');
		}
		release_freezing();
	})
	.catch(error => {
		if (error.status === 422) {
			let validationErrors = error.data.errors;
			let firstField = null;
			let errorMessages = [];
	
			// Remove previous error messages and validation styles
			document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
			document.querySelectorAll('.invalid-feedback').forEach(el => el.remove());
	
			Object.keys(validationErrors).forEach((field, index) => {
				// Find input field that contains the error field name (partial match)
				let inputField = Array.from(document.querySelectorAll('input, select, textarea')).find(el => 
					el.id.includes(field) || el.name.includes(field)
				);
			
				if (inputField) {
					inputField.classList.add('is-invalid');
			
					// Create an error message div
					let errorDiv = document.createElement('div');
					errorDiv.className = 'invalid-feedback row d-flex justify-content-center';
					errorDiv.innerHTML = validationErrors[field].join('<br>');
			
					// Find the parent form-group
					let formGroup = inputField.closest('.form-group');
			
					// If the error message doesn't already exist, append it
					if (formGroup && !formGroup.querySelector('.invalid-feedback')) {
						formGroup.appendChild(errorDiv);
					}

					errorDiv.style.display = 'block';
			
					if (index === 0) {
						firstField = inputField; // Store first invalid field
					}
				}
			
				errorMessages.push(validationErrors[field].join('<br>'));
			});
			
	
			// Focus on the first invalid field
			if (firstField) {
				firstField.focus();
			}
	
			showNotification(errorMessages.join('<br>'), 'error');
		} else {
			showNotification(error, 'error');
		}
		release_freezing();
	});
	
	
	
}

function show_files(sys_no,page_name,file_type='',show_list_view_name='',show_list_view_div_id='')
{
	if(form_validation(sys_no,'Sys No/Id')==false)
	{
		showNotification("Sys No/Id Can't be empty",'error');
		return;
	}
	else
	{
		sys_no = $(`#${sys_no}`).val();
		var title = 'File List View';
		var page_link='/common_file_popup?sys_no='+sys_no+'&page_name='+page_name+'&file_type='+file_type;
		emailwindow=dhtmlmodal.open('EmailBox', 'iframe', page_link, title, 'width=600px,height=370px,center=1,resize=1,scrolling=1','../');
		emailwindow.onclose=function()
		{
			if(show_list_view_name.length > 0 && show_list_view_div_id.length > 0)
			{
				show_list_view(show_list_view_name,'show_common_list_view',show_list_view_div_id,'/show_common_list_view','setFilterGrid("list_view",-1)');
			}
		}
	}
}

function fetchData(data, route,form_field_name)
{
  const url = `${route}?data=${data}`;
  fetch(url,{
		method: 'GET' ,
		headers: {
			'Content-Type': 'application/json',
			'X-Requested-With': 'XMLHttpRequest',
			'X-CSRF-TOKEN': '{{csrf_token()}}'// Add the CSRF token to the headers
		}
	})
	.then(response => response.text())
	.then(data => {
		try {
			if(data.length > 0 && form_field_name.length > 0)
			{
				var exp = form_field_name.split(",");
				for(var i = 0; i < exp.length; i++)
				{
					$(`#${exp[i]}`).val(data[i]);
				}
			}
		} catch (error) {
			throw new Error(error);
		}
	})
    .catch(error => {
		showNotification(error,'error');
    });
}

jQuery(document).on('change', '.field_level_access', function() {
	var str = $(this).attr('id');
	if (str.indexOf("company") > -1)
	{
		if (str != avoidCompany[0])
		{
			set_field_level_access($(this).val());
		}
	}
});


var first_values=new Array;
var first_sts = new Array;
var check_disable=new Array;
var check_value = new Array;

function set_field_level_access( company )
{
	try
	{
		if(field_level_data['action_company_id']!=undefined)
		{
			var company=$('#'+field_level_data['action_company_id']).val();
		}
	}
	catch(error)
	{
		return true;
	}
	
	$.each( first_sts, function( keys, values )
	{
		if(jQuery.inArray(values.f_titles, check_disable) == -1)
		{
			check_disable.push(values.f_titles);
			if(values.f_vals==undefined)
				$('#'+values.f_titles).attr('disabled',false);
			else
				$('#'+values.f_titles).attr('disabled',true);
		}
	});
	$.each( first_values, function( keys, values )
	{
		if(jQuery.inArray(values.f_title, check_value) == -1)
		{
			check_value.push(values.f_title);
			$('#'+values.f_title).val(values.f_val);
		}
	});
	check_value.length=0;
	check_disable.length=0;

	if( field_level_data[company]==undefined){
		return;
	}

	if(company!=0)
	{
		$.each( field_level_data[company], function( key, value )
		{
			if( value['is_disable']==1) {
				first_sts.push({
					f_titles: key,
					f_vals:  $('#'+key).attr('disabled')
				});
				$('#'+key).attr('disabled',true);
			}
			else
			{
				first_sts.push({
					f_titles: key,
					f_vals:  $('#'+key).attr('disabled')
				});
				$('#'+key).attr('disabled',false);
			}
			
			if(value['default_value']==null || value['default_value']=="undefined"){value['default_value']='';}
			
			if(value['default_value']!='')
			{ 
				if(value['default_value']=="") return;
				first_values.push({
					f_title: key,
					f_val:  $('#'+key).val()
				});
				
				 if(value['default_value']!='')
				 { 
					$('#'+key).val(value['default_value']);
					$('#'+key).change();
				 }
			}
		});
	}
}

function make_mandatory(entry_form)
{
	const url = `/get_mandatory_and_field_level_data?entry_form=${entry_form}`;
    fetch(url,{
		method: 'GET' ,
		headers: {
			'Content-Type': 'application/json',
			'X-Requested-With': 'XMLHttpRequest',
			'X-CSRF-TOKEN': '{{csrf_token()}}'// Add the CSRF token to the headers
		}
	})
	.then(response => response.text())
	.then(data => {
		try {
			if(data.length > 0)
			{
				var mandatory_field_leve_data = data.split("#");
				var mandatory_field_arr = mandatory_field_leve_data[0].split("*");
				for (var property in mandatory_field_arr) {
					$("#" + mandatory_field_arr[property]).parent().prev('label').css("color", "blue");
					$("#" + mandatory_field_arr[property]).parent().prev('td').css("color", "blue");
				}
			}
		} catch (error) {
			throw new Error(error);
		}
	})
    .catch(error => {
		showNotification(error,'error');
    });

}


function field_manager(entry_form)
{
	console.log(`field_manager(${entry_form})`);
	const url = `/get_field_manager_data?entry_form=${entry_form}`;
    fetch(url,{
		method: 'GET' ,
		headers: {
			'Content-Type': 'application/json',
			'X-Requested-With': 'XMLHttpRequest',
			'X-CSRF-TOKEN': '{{csrf_token()}}'// Add the CSRF token to the headers
		}
	})
	.then(response => response.text())
	.then(data => {
		try {
            if (data.length > 0) {
                var field_manager_data = data.split("*");
                for (var property in field_manager_data) {
                    let fieldId = field_manager_data[property];
                    console.log('fieldId',fieldId);
                   // Hide the input field
					$("#" + fieldId).css("visibility", "hidden");

					// Hide parent elements (label, div, td, etc.)
					$("#" + fieldId).closest('.form-group').css("visibility", "hidden");

                }
            }
        } catch (error) {
            throw new Error(error);
        }
	})
    .catch(error => {
		showNotification(error,'error');
    });

}


function load_all_setup(entry_form) {
	var field_level_data = sessionData.data_arr[entry_form] || {};
	var mandatoryField = sessionData.mandatory_field[entry_form] ? sessionData.mandatory_field[entry_form].join('*') : "";
	var mandatoryMessage = sessionData.mandatory_message[entry_form] ? sessionData.mandatory_message[entry_form].join('*') : "";

	make_mandatory(entry_form);
	field_manager(entry_form);

	return {
		field_level_data: field_level_data,
		mandatoryField: mandatoryField,
		mandatoryMessage: mandatoryMessage
	};
}


// Function to trigger appropriate change event
function triggerChangeEvent(selector) {
    const element = $('#'+selector)[0];  // Get the raw DOM element
    // Check if element exists and has an ID starting with 'cbo' or has the 'select2' class
    if (element && ($(element).hasClass('select2') || element.id.startsWith('cbo'))) {
        $('#'+selector).trigger('change.select2');  // Trigger Select2 change event
    } else {
        $('#'+selector).trigger('change');  // Trigger regular change event
    }
}

async function waitForDropdownUpdate(selector, expectedValue, timeout = 300) {
	return new Promise((resolve, reject) => {
		const targetNode = $('#'+selector)[0];  // jQuery object to DOM element
		if (!targetNode) return reject(`Element ${selector} not found`);

		const observer = new MutationObserver(() => {
			const optionExists = [...targetNode.options].some(opt => opt.value == expectedValue);
			console.log(`Checking ${selector} for value ${expectedValue}:`, optionExists);

			if (optionExists) {
				// Use Select2's val method to set value and trigger appropriate event
				$('#'+selector).val(expectedValue);
				triggerChangeEvent(selector);  // Trigger Select2 or regular change event based on condition
				observer.disconnect();
				console.log(`${selector} resolved with value: ${expectedValue}`);
				resolve();
			}
		});

		// Observe for options being added
		observer.observe(targetNode, { childList: true, subtree: true });

		// Safety timeout
		setTimeout(() => {
			observer.disconnect();
			const finalCheck = [...targetNode.options].some(opt => opt.value == expectedValue);
			if (finalCheck) {
				$('#'+selector).val(expectedValue);
				triggerChangeEvent(selector);
				console.log(`${selector} resolved after timeout with value: ${expectedValue}`);
				resolve();
			} else {
				reject(`Timeout: ${selector} did not resolve to ${expectedValue}`);
			}
		}, timeout);
	});
}