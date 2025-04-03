<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\FieldManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CommonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function populateCommonData(Request $request)
    {
        try
        {
            DB::enableQueryLog();
            $columnNames = implode(",",explode("*",str_replace("'","",$request->input('column_names'))));

            $common_data = DB::table($request->input('table_name'))
                ->where($request->input('filter_column_name'), $request->input('filter_column_value'))
                ->select(DB::raw($columnNames))
                ->first();
            //dd(DB::getQueryLog());
            $others = explode("*",$request->input('others'));
            $other_data = [];
            if(count($others) > 0)
            {
                foreach($others as $other)
                {
                    $od = explode(",",$other);
                    if(count($od) > 4)
                    {
                        $table = $od[0];
                        $joinColumn = $od[1];
                        $columnToRetrieve = $od[3];
                        $alias = $od[4];
                        
                        $condition_value = $common_data->{$od[2]};

                        $ord = DB::table($table)
                            ->where($joinColumn, $condition_value);

                        if($table == 'image_uploads')
                        {
                            $ord =  $ord->where('page_name', $od[5]);
                        }
                        $ord  = $ord->select(DB::raw($columnToRetrieve))
                                    ->first();
                        
                        if (!empty($ord->{$columnToRetrieve}))
                        {
                            if($table == 'image_uploads')
                            {
                                $other_data[$alias] = asset($ord->{$columnToRetrieve});
                            }
                            else
                            {
                                $other_data[$alias] =$ord->{$columnToRetrieve};
                            }
                        }
                    }
                }
            }

            return response()->json([
                'code'=>18,
                'message'=>'success',
                'data'=>$common_data,
                'others_data' => $other_data
            ]);
        }
        catch(Exception $e)
        {
            $error_message ="Error: ".$e->getMessage()." in ".$e->getFile()." at line ".$e->getLine();
            return response()->json([
                'code'=>37,
                'message'=>$error_message,
                'data'=> [
                ]
            ]);
        }
    }
    public function show_common_list_view(Request $request)
    {
        $show_list_view = $request->query('data') ?? 'show_common_list_view';
        $param = $request->query('param') ?? '';
        return view('ajax.list_view.'.$show_list_view,compact('param'));
    }
    public function show_common_popup_view(Request $request)
    {
        //dd($request->all());
        try
        {
            $param = $request->query('param') ?? '';
            $page = $request->query('page');
            if(empty($page)) throw new Exception("Page Not Found");
            $param = $request->query('param') ?? '';
            return view('ajax.popup_view.'.$page,compact('param'));
        }
        catch(Exception $e)
        {
            $error = $e->getMessage();
            return view('ajax.popup_view.show_common_popup_view',compact('error'));
        }
    }
    public function common_file_popup(Request $request)
    {
        $sys_no = $request->query('sys_no') ?? '';
        $page_name = $request->query('page_name') ?? '';
        $file_type = $request->query('file_type') ?? '';
        return view('ajax.common_file_popup',compact('sys_no','page_name','file_type'));
    }

    public function get_mandatory_and_field_level_data(Request $request)
    {
        $entry_form = $request->entry_form;
        $mandatory_field ="";
        if(session()->has("laravel_stater.mandatory_field.$entry_form"))
        {
            $mandatory_field = implode("*", session("laravel_stater.mandatory_field.$entry_form"));;
        }
        echo $mandatory_field;
    }

    public function load_drop_down(Request $request)
    {
        $action = $request->query('action') ?? '';
        $data = $request->query('data') ?? '';
        return view('ajax.drop_down.'.$action,compact('data'));
    }

    public function get_field_manager_data(Request $request)
    {
        $fieldManagerData = FieldManager::where('entry_form', $request->entry_form)
        ->where('user_id', Auth::id())
        ->where('is_hide', 1)
        ->pluck('field_name', 'field_id')
        ->toArray();

        return response()->json(array_values($fieldManagerData));
    }
}
