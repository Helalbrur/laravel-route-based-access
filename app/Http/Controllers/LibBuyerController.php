<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\LibBuyer;
use Illuminate\Http\Request;
use App\Exports\LibBuyerExport;
use App\Imports\LibBuyerImport;
use App\Models\LibBuyerTagParty;
use App\Models\LibBuyerTagCompany;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\StoreLibBuyerRequest;
use App\Http\Requests\UpdateLibBuyerRequest;

class LibBuyerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('lib.buyer');
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
        DB::beginTransaction();
        try
        {
            $lib_buyer=LibBuyer::create([
                'buyer_name'=>$request->input('txt_buyer_name'),
                'short_name'=>$request->input('txt_short_name'),
                'country_id'=>$request->input('cbo_country_name'),
                'tag_company'=>$request->input('cbo_tag_company_name'),
                'party_type'=>$request->input('cbo_tag_party_name'),
                'contact_person'=>$request->input('txt_contact_person'),
                'contact_no'=>$request->input('txt_contact_no'),
                'web_site'=>$request->input('txt_website_name'),
                'email'=>$request->input('txt_email'),
                'address'=>$request->input('txt_buyer_address'),
                'created_by'=>Auth::user()->id
            ]);
            
            if(!empty($request->input('cbo_tag_company_name')))
            {
                $companies = explode(",",$request->input('cbo_tag_company_name'));
                foreach($companies as $company_id)
                {
                    LibBuyerTagCompany::create([
                        'company_id' => $company_id,
                        'buyer_id'   => $lib_buyer->id
                    ]);
                }
            }

            if(!empty($request->input('cbo_tag_party_name')))
            {
                $parties = explode(",",$request->input('cbo_tag_party_name'));
                foreach($parties as $party_type)
                {
                    LibBuyerTagParty::create([
                        'party_type' => $party_type,
                        'buyer_id'   => $lib_buyer->id
                    ]);
                }
            }

            

           

            DB::commit();
            return response()->json([
                'code'=>0,
                'message'=>'success',
                'data'=>$lib_buyer
            ]);
        }
        catch(Exception $e)
        {
            DB::rollBack();
            $error_message ="Error: ".$e->getMessage()." in ".$e->getFile()." at line ".$e->getLine();
            return response()->json([
                'code'=>10,
                'message'=>$error_message,
                'data'=> [
                ]
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(LibBuyer $libBuyer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LibBuyer $libBuyer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LibBuyer $buyer)
    {
        DB::beginTransaction();
        try
        {
            $buyer->update([
                'buyer_name'=>$request->input('txt_buyer_name'),
                'short_name'=>$request->input('txt_short_name'),
                'country_id'=>$request->input('cbo_country_name'),
                'tag_company'=>$request->input('cbo_tag_company_name'),
                'party_type'=>$request->input('cbo_tag_party_name'),
                'contact_person'=>$request->input('txt_contact_person'),
                'contact_no'=>$request->input('txt_contact_no'),
                'web_site'=>$request->input('txt_website_name'),
                'email'=>$request->input('txt_email'),
                'address'=>$request->input('txt_buyer_address'),
                'updated_by'=>Auth::user()->id
            ]);

            if(!empty($request->input('cbo_tag_company_name')))
            {
                $companies = explode(",",$request->input('cbo_tag_company_name'));
                //$buyer->tagCompany;
                foreach($buyer->tagCompany as $tag)
                {
                    $tag->delete();
                }
                foreach($companies as $company_id)
                {
                    LibBuyerTagCompany::create([
                        'company_id' => $company_id,
                        'buyer_id'   => $buyer->id
                    ]);
                }
            }

            if(!empty($request->input('cbo_tag_party_name')))
            {
                foreach($buyer->tagParty as $tag)
                {
                    $tag->delete();
                }
                $parties = explode(",",$request->input('cbo_tag_party_name'));
                foreach($parties as $party_type)
                {
                    LibBuyerTagParty::create([
                        'party_type' => $party_type,
                        'buyer_id'   => $buyer->id
                    ]);
                }
            }
    
            DB::commit();
            return response()->json([
                'code'=>1,
                'message'=>'success',
                'data'=>$buyer
            ]);
        }
        catch(Exception $e)
        {
            $error_message ="Error: ".$e->getMessage()." in ".$e->getFile()." at line ".$e->getLine();
            return response()->json([
                'code'=>10,
                'message'=>$error_message,
                'data'=> [
                ]
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LibBuyer $buyer)
    {
        DB::beginTransaction();
        try
        {
            
            foreach($buyer->tagCompany() as $tag)
            {
                $tag->delete();
            }
            foreach($buyer->tagParty as $tag)
            {
                $tag->delete();
            }
            $buyer->delete();

            DB::commit();
            return response()->json([
                'code'=>2,
                'message'=>'success',
                'data'=>[]
            ]);
        }
        catch(Exception $e)
        {
            DB::rollBack();
            $error_message ="Error: ".$e->getMessage()." in ".$e->getFile()." at line ".$e->getLine();
            return response()->json([
                'code'=>10,
                'message'=>$error_message,
                'data'=> [
                ]
            ]);
        }
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimetypes:text/plain,text/csv,application/csv,application/vnd.ms-excel',
        ]);
        
        $extension = $request->file('file')->getClientOriginalExtension();
        if (!in_array($extension, ['csv', 'xlsx'])) {
            return back()->withErrors(['file' => 'Invalid file format. Please upload a CSV or Excel file.']);
        }

        try {
            Excel::import(new LibBuyerImport, $request->file('file'));

            return response()->json([
                'code' => 0,
                'message' => 'Import successful',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 10,
                'message' => "Error: " . $e->getMessage(),
            ]);
        }
    }

    public function export()
    {
        return Excel::download(new LibBuyerExport, 'lib_buyers.csv');
    }

}
