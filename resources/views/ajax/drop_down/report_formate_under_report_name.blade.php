<?php
if($data==1) $report_format_id="1,2";//Location Profile
else if($data==2) $report_format_id="2,3";//Buyer Profile
else if($data==2) $report_format_id="1,3";//Supplier Profile
else $report_format_id="0";

echo create_drop_down( "cbo_format_name", "100%", report_format(),"", 0, "--- Select Report ---", 0, "","",$report_format_id ,"","","","","","","select2","",1);
exit();
?>