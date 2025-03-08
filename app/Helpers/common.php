<?php

$db_type=0; //$db_type=(0=Mysql,1=mssql,2=oracle);

$tna_process_type=1; //1 for Regular Process, 2 for Percentage based new process
$select_job_year_all=0;
//$tna_process_start_date="2014-12-01";

if($db_type==0)
{
	$tna_process_start_date="2014-12-01";
}
if($db_type==2)
{
	$tna_process_start_date="01-Dec-2014";
}

$pc_time= date("H:i:s",time());

if($db_type==0) $pc_date_time = date("Y-m-d H:i:s",time());
else $pc_date_time = date("d-M-Y h:i:s A",time());

if($db_type==0) $pc_date = date("Y-m-d",time());
else $pc_date = date("d-M-Y",time());


function base_url($file)
{
    //return 'http://localhost/platform-v3.5/'.$file;
	$dir_arr=explode('/',$_SERVER['REQUEST_URI']);
	$port = '';
	if (!in_array($_SERVER['SERVER_PORT'], [80, 443])) {
        $port = ":$_SERVER[SERVER_PORT]";
    }
	$http = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on'? "https://" : "http://";
	$base_url=$http .$_SERVER['SERVER_NAME'].$port.'/'.$dir_arr[1].'/'.$file;
	return $base_url;
}
?>
