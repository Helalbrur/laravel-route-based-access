<?php

namespace App\Models;

use Exception;
use File;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class ImageUpload extends Model
{
    use HasFactory;
    protected $fillable = ['file_name','file_type','sys_no','page_name','created_by'];
    public static function fileUploads($query,$sys_no,$page_name,$file_type=1) // Taking input image as parameter
    {
        try
        {
            $image_name = time();
            $ext = strtolower($query->getClientOriginalExtension()); // You can use also getClientOriginalName()
            $image_full_name = $image_name.'.'.$ext;
            $upload_path = 'common_uploads/';    //Creating Sub directory in Public folder to put image
            $image_url = $upload_path.$image_full_name;
            $success = $query->move($upload_path,$image_full_name);
            ImageUpload::create([
                'file_name' => $image_url,
                'file_type' => $file_type,
                'sys_no' => $sys_no,
                'page_name' => $page_name,
                'created_by' =>Auth::user()->id
            ]);
        }
        catch(Exception $e)
        {

        }
    }
    public static function removeFiles($sys_no,$page_name,$file_type=1)
    {
        try
        {
            $images = ImageUpload::where('page_name',$page_name)->where('sys_no',$sys_no)->where('file_type',$file_type)->get();
            foreach($images as $image)
            {
                if(File::exists($image->file_name)) {
                    File::delete($image->file_name);
                }
                $image->delete();
            }
            return "success";
        }
        catch(Exception $e)
        {
            return $e;
        }

    }
}
