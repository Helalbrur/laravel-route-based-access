
<?php
    if($data==1) //Module ID---Lib
	{
		$report_format_name="1,2,3"; //Menu ID //echo $report_format_name;
	}
	
	else if($data==10) //Module ID---Admin
	{
		$report_format_name="0"; //Menu ID
	}
	else
	{
		$report_format_name="0";
	}

	echo create_drop_down( "cbo_report_name", "100%", report_name(),"", 1, "--- Select Report ---", 0, "","",$report_format_name );
	exit();
	//load_drop_down( 'load_drop_down', this.value, 'report_formate_under_report_name', 'format_div' );
?>
