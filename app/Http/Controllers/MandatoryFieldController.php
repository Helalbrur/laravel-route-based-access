<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MandatoryField;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MandatoryFieldController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('tools.mandatory_field');
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
        //insert , update
        if($request->operation==0 || $request->operation==1)
        {
            try
            {
                DB::beginTransaction();
                $cbo_page_id = str_replace("'","",$request->cbo_page_id);
                $fieldlevel_arr = fieldlevel_arr();;
                
                $duplicates = MandatoryField::where('page_id',$cbo_page_id)->get();
                if(count($duplicates) > 0)
                {
                    foreach($duplicates as $dup)
                    {
                        $dup->delete();
                    }
                }
                
                for($i=1;$i<=$request->total_row;$i++)
                {     
                    $cboFieldId=str_replace("'","",$request['cboFieldId_'.$i]);
                    $txtFieldName=$fieldlevel_arr[$cbo_page_id][$cboFieldId];
                    $txtFieldMessage=ucwords(str_replace(array('cbo','txt','_'),array("",""," "),$fieldlevel_arr[$cbo_page_id][$cboFieldId]));
                    $cboIsMandatory=str_replace("'","",$request['cboIsMandatory_'.$i]);
                    MandatoryField::create([
                        'page_id' => $request->cbo_page_id,
                        'field_id' => $cboFieldId,
                        'field_name' => $txtFieldName,
                        'field_message' => trim($txtFieldMessage),
                        'is_mandatory' => $cboIsMandatory,
                        'created_by' => Auth::user()->id
                    ]);      
                }
                DB::commit();
                return response([
                    'code' => $request->operation,
                    'message' => 'success',
                    'page_id' => $cbo_page_id
                ]);
            }
            catch(Exception $e)
            {
                DB::rollBack();
                $error_message ="Error: ".$e->getMessage()." in ".$e->getFile()." at line ".$e->getLine();
                return response([
                    'code' => 10,
                    'message' => $error_message,
                    'page_id' => $cbo_page_id
                ]);
            } 
        }

        //delete
        if($request->operation==2)
        {
            $cbo_page_id = str_replace("'","",$request->cbo_page_id);
            $duplicates = MandatoryField::where('page_id',$cbo_page_id)->get();
            if(count($duplicates) > 0)
            {
                foreach($duplicates as $dup)
                {
                    $dup->delete();
                }
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(MandatoryField $mandatory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MandatoryField $mandatory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MandatoryField $mandatory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MandatoryField $mandatory)
    {
        //
    }

    public function entry_form_popup()
    {
        return view('ajax.entry_form_popup');
    }
    public function load_drop_down_mandatory_field_item(Request $request)
    {
        $data = $request->query('data') ?? 0;
        $field_arr=get_fieldlevel_arr($data);
        //dd($field_arr);
        echo create_drop_down( "cboFieldId_1","100%",$field_arr,"",1,"----Select----",0,"","","","","","","","","cboFieldId[]" );
	    exit();
    }
    public function mandatory_action_user_data(Request $request)
    {
        $data = $request->query('data');

        $array = DB::select("SELECT id, page_id, field_id, field_name, is_mandatory FROM mandatory_field WHERE page_id = ? ", [$data]);

        $data_array = [];
        $i = 0;
        $str = '';

        if (count($array) > 0)
        {
            foreach ($array as $row)
            {
                array_push($data_array,[
                    'id'            =>$row->id,
                    'page_id'       =>$row->page_id,
                    'field_id'      =>$row->field_id,
                    'field_name'    =>$row->field_name,
                    'is_mandatory'  =>$row->is_mandatory
                ]);
                if ($i == 0)
                    $str = $row->id . '*' . $row->page_id . '*' . $row->field_id . '*' . $row->field_name . '*' . $row->is_mandatory;
                else
                    $str .= '@@' . $row->id . '*' . $row->page_id . '*' . $row->field_id . '*' . $row->field_name . '*' . $row->is_mandatory;

                $i++;
            }
        }
        return response()->json($data_array);
    }
}
