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
    
    public static function fileUpload($files, $sys_no, $page_name,$ex='')
    {
        try {
            $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp'];
            foreach ($files as $file)
            {
                $original_name = $file->getClientOriginalName();
                $file_size = $file->getSize();
                $ext = strtolower($file->getClientOriginalExtension());
                $image_full_name = $original_name . '_' . $file_size . '_' . $page_name . '.' . $ext;
                $upload_path = 'common_uploads/';
                $image_url = $upload_path . $image_full_name;

                // Check if the file already exists in the target directory
                if (!file_exists($upload_path . $image_full_name)) {
                    $success = $file->move($upload_path, $image_full_name);

                    // Determine the file type based on the extension
                    if (in_array(strtolower($ext), $imageExtensions)) {
                        $file_type = 1; // Image file type
                    } else {
                        $file_type = 2; // Other file types (e.g., PDF)
                    }

                    ImageUpload::create([
                        'file_name' => $image_url,
                        'file_type' => $file_type,
                        'sys_no' => $sys_no,
                        'page_name' => $page_name,
                        'created_by' => Auth::user()->id
                    ]);
                }
            }
        } catch (Exception $e) {
            // Handle the exception appropriately
        }
    }

    public static function fileUploads($files, $sys_no, $page_name,$ex='')
    {
        try {
            $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp'];
            foreach ($files as $file)
            {
                $original_name = $file->getClientOriginalName();
                $file_size = $file->getSize();
                $ext = strtolower($file->getClientOriginalExtension());
                $image_full_name = $original_name . '_' . $file_size . '_' . $page_name . '.' . $ext;
                $upload_path = 'common_uploads/';
                $image_url = $upload_path . $image_full_name;

                // Check if the file already exists in the target directory
                if (!File::exists($image_url)) {
                    $success = $file->move($upload_path, $image_full_name);

                    // Determine the file type based on the extension
                    if (in_array(strtolower($ext), $imageExtensions)) {
                        $file_type = 1; // Image file type
                    } else {
                        $file_type = 2; // Other file types (e.g., PDF)
                    }

                    ImageUpload::create([
                        'file_name' => $image_url,
                        'file_type' => $file_type,
                        'sys_no' => $sys_no,
                        'page_name' => $page_name,
                        'created_by' => Auth::user()->id
                    ]);
                }
            }
        } catch (Exception $e) {
            dd($e);
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
