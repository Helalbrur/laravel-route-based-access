<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\FieldManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\StoreFieldManagerRequest;
use App\Http\Requests\UpdateFieldManagerRequest;

class FieldManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('tools.field_manager');
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
                $cbo_entry_form = str_replace("'","",$request->cbo_entry_form);
                $fieldlevel_arr = field_manager_arr();;
                
                $duplicates = FieldManager::where('entry_form',$cbo_entry_form)->where('user_id',$request->cbo_user_id)->get();
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
                    $txtFieldName=$fieldlevel_arr[$cbo_entry_form][$cboFieldId];
                    $txtFieldMessage=ucwords(str_replace(array('cbo','txt','_'),array("",""," "),$fieldlevel_arr[$cbo_entry_form][$cboFieldId]));
                    $cboIsHide=str_replace("'","",$request['cboIsHide_'.$i]);
                    FieldManager::create([
                        'entry_form'        => $request->cbo_entry_form,
                        'field_id'          => $cboFieldId,
                        'field_name'        => $txtFieldName,
                        'field_message'     => trim($txtFieldMessage),
                        'is_hide'           => $cboIsHide,
                        'user_id'           => $request->cbo_user_id,
                        'created_by'        => Auth::user()->id
                    ]);      
                }
                DB::commit();
                Cache::forget("field_manager_{$request->cbo_user_id}");
                $this->cacheFieldManagerData($request->cbo_user_id);
                return response([
                    'code' => $request->operation,
                    'message' => 'success',
                    'entry_form' => $cbo_entry_form
                ]);
            }
            catch(Exception $e)
            {
                DB::rollBack();
                $error_message ="Error: ".$e->getMessage()." in ".$e->getFile()." at line ".$e->getLine();
                return response([
                    'code' => 10,
                    'message' => $error_message,
                    'entry_form' => $cbo_entry_form
                ]);
            } 
        }

        //delete
        if($request->operation==2)
        {
            $cbo_entry_form = str_replace("'","",$request->cbo_entry_form);
            $duplicates = FieldManager::where('entry_form',$cbo_entry_form)->where('user_id',$request->cbo_user_id)->get();
            if(count($duplicates) > 0)
            {
                foreach($duplicates as $dup)
                {
                    $dup->delete();
                }
            }
        }
    }

    protected function cacheFieldManagerData($userId)
    {
        Cache::forget("field_manager_{$userId}");
        $data = FieldManager::where('user_id', $userId)
            ->get()
            ->groupBy('entry_form')
            ->map(function($items) {
                return $items->where('is_hide', 1)
                            ->pluck('field_name')
                            ->toArray();
            });
        
        Cache::put("field_manager_{$userId}", $data, now()->addDay());
    }

    /**
     * Display the specified resource.
     */
    public function show(FieldManager $fieldManager)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FieldManager $fieldManager)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFieldManagerRequest $request, FieldManager $fieldManager)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FieldManager $fieldManager)
    {
        //
    }

    public function entry_form_popup()
    {
        return view('ajax.entry_form_popup');
    }

    public function load_drop_down_field_manager_item(Request $request)
    {
        $data = $request->query('data') ?? 0;
        $field_arr=get_field_manager_arr($data);
        //dd($field_arr);
        echo create_drop_down( "cboFieldId_1",200,$field_arr,"",1,"----Select----",0,"","","","","","","","","cbo_field_id[]" );
	    exit();
    }
    public function field_manager_action_user_data(Request $request)
    {
        try
        {
            $data = json_decode($request->query('data'), true);

            $data = json_decode($request->query('data'), true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception('Invalid JSON format');
            }

            if (!isset($data['entry_form']) || !isset($data['user_id'])) {
                throw new Exception('Missing required parameters');
            }

            $entry_form = $data['entry_form'];
            $user_id    = $data['user_id'];

            // $array = DB::select("SELECT id, entry_form, field_id, field_name, is_hide FROM field_managers WHERE entry_form = ? and user_id = ?", [$entry_form,$user_id]);

            $array = FieldManager::where('user_id',$user_id)->where('entry_form' , $entry_form)->get();

            $data_array = [];
            
            if (count($array) > 0)
            {
                foreach ($array as $row)
                {
                    array_push($data_array,[
                        'id'            =>$row->id,
                        'page_id'       =>$row->entry_form,
                        'field_id'      =>$row->field_id,
                        'field_name'    =>$row->field_name,
                        'is_hide'       =>$row->is_hide
                    ]);
                }
            }
            return response()->json($data_array);
        }
        catch(Exception $e)
        {
            return response()->json([
                'error' => $e->getMessage()
            ],500);
        }
    }
}
