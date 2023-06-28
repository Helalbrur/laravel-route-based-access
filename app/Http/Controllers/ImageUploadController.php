<?php

namespace App\Http\Controllers;
use File;
use Exception;
use App\Models\ImageUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ImageUploadController extends Controller
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
    public function show(ImageUpload $imageUpload)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ImageUpload $imageUpload)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ImageUpload $imageUpload)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,ImageUpload $image)
    {
        DB::beginTransaction();
        try
        {
            $record = ImageUpload::find($request->id);
            if(File::exists($record->file_name)) {
                File::delete($record->file_name);
            }
            $record->delete();
            DB::commit();
            return response()->json([
                'code'=>2,
                'message'=>'success',
                'data'=>$record
            ]);
        }
        catch(Exception $e)
        {
            DB::rollBack();
            return response()->json([
                'code'=>10,
                'message'=>$e->getMessage(),
                'data'=> $image
            ]);
        }
    }
}
