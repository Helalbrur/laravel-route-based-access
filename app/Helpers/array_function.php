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
    return array(1 => "Group Profile", 2 => "Company Profile", 3 => "Item Group", 4 => "Item Sub Group", 5 => "Country" , 6 => "Color", 7 => "Size", 8 => "Location", 9 => "Buyer Profile", 10 => "Supplier Profile", 11 => "Brand Entry", 12 => "Work Order", 13 => "Item Creation");
}

function yes_no()
{
    return array(1 => "Yes", 2 => "No");
}

function currency()
{
    return array(1 => "BDT", 2 => "USD", 3 => "EURO", 4 => "CHF", 5 => "SGD", 6 => "Pound", 7 => "YEN");
}

function get_pay_mode()
{
    return array(1 => "Credit", 2 => "Import", 3 => "In House", 4 => "Cash", 5 => "Within Group",6=>"Bank",7=>"Mobile Fund");
}

function party_type()
{
    return array(1=>"Buyer", 2=>"Subcontract", 3=>"Buyer/Subcontract", 4=>"Notifying Party", 5=>"Consignee", 6=>"Notifying/Consignee", 7=>"Client",8=>"Customer", 20=>"Buying Agent", 21=>"Buyer/Buying Agent", 22=>"Export LC Applicant", 23=>"LC Applicant/Buying Agent", 30=>"Developing Buyer", 80=>"Other Buyer", 90=>"Buyer/Supplier", 100=>"Also Notify Party");
}

function party_type_supplier()
{
   return array(1 => "Supplier", 2 => "Yarn Supplier", 3 => "Dyes & Chemical Supplier", 4 => "Trims Supplier", 5 => "Accessories Supplier", 6 => "Machineries Supplier", 7 => "General Item", 8 => "Stationery Supplier", 9 => "Leather & Synthetic Supplier", 20 => "Knit Subcontract", 21 => "Dyeing/Finishing Subcontract", 22 => "Finish Footwear Subcontract", 23 => "Embellishment Subcontract", 24 => "Fabric Washing Subcontract", 25 => "AOP Subcontract", 26 => "Lab Test Company", 30 => "C & F Agent", 31 => "Clearing Agent", 32 => "Forwarding Agent", 35 => "Transport Supplier", 36 => "Labor Contractor", 37 => "Civil Contractor", 38 => "Interior", 39 => "Other Contractor", 40 => "Indentor", 41 => "Inspection", 90 => "Buyer/Supplier", 91 => "Loan Party", 92 => "Vehicle Components", 93 => "Twisting", 94 => "Re-Waxing", 95 => "Grey Fabric Service Subcontract",96 => "Trims Sub-Contract", 130 => "General Accessories Service");
}

function get_all_month()
{
    return  array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December');
}
function get_all_month_short_name()
{
    return  array(1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec');
}

function get_all_year()
{
    $year = array();

    for($y = 2010;$y <=date('Y')+10;$y++)
    {
        $year[$y] = $y;
    }
    return $year;
}

function get_all_day()
{
    return array(1 => "Saturday", 2 => "Sunday", 3 => "Monday", 4 => "Tuesday", 5 => "Wednesday", 6 => "Thursday", 7 => "Friday");
}
function user_type()
{
    return array(1 => "Admin", 2 => "Editor", 3 => "Visitor");
}

function report_name()
{
    return array(1 => "Location", 2 => "Buyer Profile", 3 => "Supplier Profile");
}

function report_format()
{
    return array(1 => "Print", 2 => "Print B1", 3 => "Print B2", 4 => "Print B3");
}

function module_name()
{
    return  App\Models\MainModule::pluck('main_module', 'm_mod_id');
}
function user_names()
{
    return App\Models\User::pluck('name', 'id');
}

function get_all_user()
{
    return App\Models\User::pluck('name', 'id')->toArray();
}

function get_all_company()
{
    return App\Models\Company::pluck('company_name', 'id')->toArray();
}

function get_all_company_name()
{
    return App\Models\Company::pluck('company_name', 'id');
}

function variable_setting()
{
    return array(1 => "Item Code System Generated");
}

function get_source()
{
    return array(1 => "Foreign", 2 => "Local");
}

function get_all_supplier()
{
    return App\Models\LibSupplier::pluck('supplier_name', 'id')->toArray();
}

function get_all_store()
{
    return App\Models\LibStoreLocation::pluck('store_name', 'id')->toArray();
}

function get_all_department()
{
    return App\Models\LibDepartment::pluck('department_name', 'id')->toArray();
}

function transaction_type()
{
    return array(1 => "Receive", 2 => "Issue", 3 => "Receive Return", 4 => "Issue Return", 5 => "Item Transfer Receive", 6 => "Item Transfer Issue");
}

function get_generic_name()
{
    return App\Models\LibGeneric::pluck('generic_name', 'id')->toArray();
}

function get_issue_basis()
{
    return array(1 => "Independent", 2 => "Requisition");
}

?>
