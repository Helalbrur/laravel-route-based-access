<fieldset style="width:650px">
    <?php
    $yes_no = array(1 => "Yes", 2 => "No");
    $arr=array(3=>$yes_no);
    echo  create_list_view ( "list_view", " Module Name,File Location,Sequence,Visiblity", "150,100,150","600","220",0, "select  main_module,file_name,mod_slno,status,m_mod_id from main_module order by mod_slno", "load_php_data_to_form", "m_mod_id", "", 1, "0,0,0,status", $arr , "main_module,file_name,mod_slno,status", "tools/create_main_module/get_data_by_id", 'setFilterGrid("list_view",-1);','0,0,0,0' ) ;
?>
</fieldset>
