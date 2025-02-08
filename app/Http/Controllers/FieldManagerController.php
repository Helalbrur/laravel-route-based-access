<?php

namespace App\Http\Controllers;

use App\Models\FieldManager;
use Illuminate\Support\Facades\Request;
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
    public function store(StoreFieldManagerRequest $request)
    {
        //
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
        $field_arr=get_fieldlevel_arr($data);
        //dd($field_arr);
        echo create_drop_down( "cboFieldId_1",200,$field_arr,"",1,"----Select----",0,"","","","","","","","","cbo_field_id[]" );
	    exit();
    }
    public function field_manager_action_user_data(Request $request)
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
