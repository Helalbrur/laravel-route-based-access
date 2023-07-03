<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FieldLevelAccess;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class FieldLevelAccessController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('tools.field_level_access');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(FieldLevelAccess $fieldLevelAccess)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FieldLevelAccess $fieldLevelAccess)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FieldLevelAccess $fieldLevelAccess)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FieldLevelAccess $fieldLevelAccess)
    {
        //
    }
    public function field_level_access_user()
    {
        return view('ajax.field_level_access_user');
    }
    public function load_drop_down_field_level_access(Request $request)
    {
        $field_arr=get_fieldlevel_access_arr($request->data);
        echo create_drop_down( "cboFieldId_1",200,$field_arr,"",1,"----Select----",0,"set_hide_data(this.value+'**'+1);","","","","","","","","cbo_field_id" );
        exit();
    }
    public function field_level_action_user_data(Request $request)
    {
        $data_ref=explode("**",$request->data);
        $com_id=$data_ref[0];
        $user_id=$data_ref[1];
        $page_id=$data_ref[2];

        $user_id_arr = explode(",",$user_id);
        $user_id_arr = implode(",",array_unique($user_id_arr));

        $userId = Auth::user()->id;
        
        
        
        $array=DB::select("SELECT a.id, a.mst_id, a.field_id, a.field_name, a.is_disable, a.defalt_value, a.user_id from field_level_access a where a.company_id=$com_id and a.user_id in ($user_id_arr) and a.page_id=$page_id ");


        //$field_arr=get_fieldlevel_access_arr($page_id);
        $str='0';
        $i=0;
        $data_array = [];
        if(count($array)>0)
        {
            foreach($array as $row)
            {
                if($i==0)
                    $str=$row[csf("id")]."*".$row[csf("mst_id")]."*".$row[csf("field_id")]."*".$row[csf("field_name")]."*".$row[csf("is_disable")]."*".$row[csf("defalt_value")]."*".$row[csf("user_id")];
                else
                    $str .="@@".$row[csf("id")]."*".$row[csf("mst_id")]."*".$row[csf("field_id")]."*".$row[csf("field_name")]."*".$row[csf("is_disable")]."*".$row[csf("defalt_value")]."*".$row[csf("user_id")];
                $i++;
                array_push($data_array,[
                    'id'            =>$row->id,
                    'mst_id'        =>$row->mst_id,
                    'page_id'       =>$page_id,
                    'field_id'      =>$row->field_id,
                    'field_name'    =>$row->field_name,
                    'is_disable'    =>$row->is_disable,
                    'defalt_value'  =>$row->defalt_value,
                    'user_id'       =>$row->user_id
                ]);
            }
        }
        return response()->json($data_array);
    }
    function set_field_name(Request $request)
    {
        $data_ref=explode("**",$request->data);
        $fieldlevel_arr = fieldlevel_access_arr();
        $field_val=$fieldlevel_arr[$data_ref[0]][$data_ref[1]];

        if($data_ref[0]==1)
        {
            if($data_ref[1]==6)
            {
                echo create_drop_down( "setDefaultVal_".$data_ref[2], 150, $currency,"",1,"----Select----",0,"","","","","","","","","" );
            }
            if($data_ref[1]==7)
            {
                echo '<input type="text" name="setDefaultVal_"'.$data_ref[2].' id="setDefaultVal_"'.$data_ref[2].' class="text_boxes" style="width:140px;" />';
            }	
        }
        else if($data_ref[0]==147)
        {
            if($data_ref[1]==1)
                echo create_drop_down( "setDefaultVal_".$data_ref[2], 150, $pay_mode,"",1,"----Select----",0,"","","","","","","","","" );	
            else
                echo '<input type="text" name="setDefaultVal_'.$data_ref[2].'" id="setDefaultVal_'.$data_ref[2].'" class="text_boxes" style="width:140px;" />';
        }
        else
        {
            echo '<input type="text" name="setDefaultVal_'.trim($data_ref[2]).'" id="setDefaultVal_'.trim($data_ref[2]).'" class="text_boxes" style="width:140px;" />';
        }
        ?>	
        <input type="hidden" name="txtFieldName[]"  id="txtFieldName_<? echo $data_ref[2];?>" value="<? echo $field_val; ?>" class="text_boxes" style="width:100px;" />

        <input type="hidden" name="hiddenPaymode" id="hiddenPaymode" />
        <?php
        exit();

    }
}
