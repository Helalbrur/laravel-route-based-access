<?php

function get_fieldlevel_access_arr( $index )
{
    $fieldlevel_arr = fieldlevel_access_arr();
	$field_arr=array();
	foreach($fieldlevel_arr[$index] as $key=>$val)
	{
		$value=explode("_",$val);
		$i=0;
		$str='';
		foreach($value as $k=>$v)
		{
			if(count($value)==1){$str =" ".ucwords (str_replace(array('cbo','txt'),'',$v));}
			else if($i!=0)$str .=" ".ucwords ($v);

			$i++;
		}
		$field_arr[$key]= $str;
	}
	return $field_arr;
}

function fieldlevel_access_arr()
{
    $fieldlevel_arr = array();
    $fieldlevel_arr[3][1]="txt_item_group_code"; //Item Group
	$fieldlevel_arr[8][1]="cbo_country_name"; //Location
    return $fieldlevel_arr;
}


?>