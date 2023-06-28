<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            $columnNames = implode(",",explode("*",str_replace("'","",$request->input('column_names'))));

            $common_data = DB::table($request->input('table_name'))
                ->where($request->input('filter_column_name'), $request->input('filter_column_value'))
                ->select(DB::raw($columnNames))
                ->first();
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
        return view('ajax.'.$show_list_view);
    }
    public function common_file_popup(Request $request)
    {
        $sys_no = $request->query('sys_no') ?? '';
        $page_name = $request->query('page_name') ?? '';
        $file_type = $request->query('file_type') ?? '';
        return view('ajax.common_file_popup',compact('sys_no','page_name','file_type'));
    }
}
