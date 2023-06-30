<?php

function get_item_category()
{
    $item_category = return_library_array("select id, short_name from  lib_category where deleted_at is null order by short_name", "id", "short_name");
    return $item_category;
}

function get_row_status()
{
    $row_status = array(1 => "Active", 2 => "InActive", 3 => "Cancelled");
    return $row_status;
}

function row_status()
{
    return array(1 => "Active", 2 => "InActive", 3 => "Cancelled");
}

function mod_permission_type(){
    return array(0 => "Selective Permission", 1 => "Full Permission", 2 => "No Permission");
}

function selected()
{
    return 0;
}

function blank_array()
{
    return array();
}

function form_permission_type()
{
    return array(1 => "Permitted", 2 => "Not Permitted");
}

function get_uom()
{
    return array(1 => "Pcs", 2 => "Dzn", 3 => "Grs", 4 => "GG", 10 => "Mg", 11 => "Gm", 12 => "Kg", 13 => "Quintal", 14 => "Ton", 15 => "Lbs", 20 => "Km", 21 => "Hm", 22 => "Dm", 23 => "Mtr", 24 => "Dcm", 25 => "CM", 26 => "MM", 27 => "Yds", 28 => "Feet", 29 => "Inch", 30 => "CFT", 31 => "SFT", 40 => "Ltr", 41 => "ML", 50 => "Roll", 51 => "Coil", 52 => "Cone", 53 => "Bag", 54 => "Box", 55 => "Drum", 56 => "Bottle", 57 => "Pack", 58 => "Set", 59 => "Can", 60 => "Each", 61 => "Gallon", 62 => "Lachi",63 => "Pair",  64 => "Lot", 65 => "Packet", 66 => "Pot", 67 => "Book", 68 => "Culind", 69 => "Rim", 70 => "Cft", 71 => "Syp", 72 => "K.V", 73 => "CU-M3", 74 => "Bundle", 75 => "Strip", 76 => "SQM", 77 => "Ounce", 78 => "Cylinder", 79 => "Course", 80 => "Sheet", 81 => "RFT", 82 => "Square Inch", 83 => "Carton", 84 => "Thane", 85 => "Gross Yds", 86 => "Jar", 87 => "Reel", 88 => "CBM",90=>"KVA",91=>"KW",92=>"Pallet",93=>"Case", 189 => "Bar", 190=>"Pound");
}

function get_entry_form()
{
    return array(1 => "Group Profile", 2 => "Company Profile", 3 => "Item Group", 4 => "Item Sub Group");
}

function yes_no()
{
    return array(1 => "Yes", 2 => "No");
}
?>
