<?php

namespace App\Http\Controllers;

use App\Models\UserPrivMst;
use App\Models\UserPrivModule;
use App\Http\Requests\StoreUserPrivMstRequest;
use App\Http\Requests\UpdateUserPrivMstRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;

class UserPrivMstController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('tools.user_previledge');
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
            $cbo_set_module_privt=str_replace("'","",$request->cbo_set_module_privt);
            $cbo_user_name=str_replace("'","",$request->cbo_user_name);
            $cbo_main_module=str_replace("'","",$request->cbo_main_module);
            $cbo_visibility=str_replace("'","",$request->cbo_visibility);
            $cbo_delete=str_replace("'","",$request->cbo_delete);
            $cbo_insert=str_replace("'","",$request->cbo_insert);
            $cbo_edit=str_replace("'","",$request->cbo_edit);
            $cbo_approve=str_replace("'","",$request->cbo_approve);

            if( $cbo_set_module_privt == 2  ) 
            {
                $nameArray=sql_select( "SELECT module_id,user_id FROM user_priv_module WHERE user_id in(".$cbo_user_name.") AND module_id = $cbo_main_module" );
                foreach ($nameArray as $inf)
                {
                    execute_query( "delete from user_priv_module where user_id =".$inf[csf("user_id")]." AND module_id = ".$inf[csf("module_id")]."");
                    execute_query( "delete from user_priv_mst where main_menu_id in ( select m_menu_id from main_menu where  m_module_id=".$inf[csf("module_id")]." ) and user_id=".$inf[csf("user_id")]."");
                }
            }  
            //01 Set Selected Module or menu not visible as a whole
            
            //02 Set Selected Module or menu  visible as a whole
            else if( $cbo_set_module_privt == 1  ) 
            {
                $nameArray1=sql_select( "SELECT m_menu_id FROM main_menu WHERE m_module_id = $cbo_main_module and status=1" );
                $count=count($nameArray1);
                    
                $cbo_user_arr=explode(",",$cbo_user_name);
                foreach($cbo_user_arr as $single_user)
                {
                    UserPrivModule::create([
                        'user_id' => $single_user,
                        'module_id' => $cbo_main_module,
                        'valid' => 1
                    ]);
                    foreach ($nameArray1 as $inf)
                    {
                        
                        UserPrivMst::create([
                            'user_id' => $single_user,
                            'main_menu_id' => $inf[csf("m_menu_id")],
                            'show_priv' => 1,
                            'delete_priv' => 1,
                            'save_priv' => 1,
                            'edit_priv' => 1,
                            'approve_priv' => 1,
                            'valid' => 1,
                            'inserted_by' => Auth::user()->id,
                            'entry_date' => strtotime(date('Y-m-d')),
                        ]);
                        
                    }
                }
                
                execute_query( "delete from user_priv_module where user_id in (".$cbo_user_name.") AND module_id = $cbo_main_module");
                execute_query( "delete from user_priv_mst where main_menu_id in ( select m_menu_id from main_menu where  m_module_id=$cbo_main_module ) and user_id in (".$cbo_user_name.")");
            }
            //02 Set Selected Module or menu  visible as a whole
            
            //03 Set Selected Module or menu  visible as a partial
            else if( $cbo_set_module_privt == 0  ) 
            {
                $cbo_user_arr=explode(",",$cbo_user_name);
                $cbo_main_menu_name=str_replace("'","",$request->cbo_main_menu_name);
                //dd($cbo_main_menu_name);
                $cbo_sub_main_menu_name=str_replace("'","",$request->cbo_sub_main_menu_name);
                $cbo_sub_menu_name=str_replace("'","",$request->cbo_sub_menu_name);
                
                if ($cbo_main_menu_name!=0 && $cbo_sub_main_menu_name!=0 && $cbo_sub_menu_name!=0)
                {
                    execute_query( "delete from user_priv_mst where main_menu_id in ( select m_menu_id from main_menu where m_module_id=$cbo_main_module ) and user_id in (".$cbo_user_name.") and main_menu_id in ($cbo_main_menu_name,$cbo_sub_main_menu_name,$cbo_sub_menu_name)");
                    foreach($cbo_user_arr as $single_user)
                    {
                        $nameArray=sql_select( "SELECT * FROM user_priv_module WHERE user_id=".$single_user." AND module_id = $cbo_main_module" );
                        
                        if (count($nameArray)<1)
                        {
                            UserPrivModule::create([
                                'user_id' => $single_user,
                                'module_id' => $cbo_main_module,
                                'valid' => 1
                            ]);
                        }

                        UserPrivMst::create([
                            'user_id' => $single_user,
                            'main_menu_id' => $cbo_main_menu_name,
                            'show_priv' => 1,
                            'delete_priv' => 1,
                            'save_priv' => 1,
                            'edit_priv' => 1,
                            'approve_priv' => 1,
                            'valid' => 1,
                            'inserted_by' => Auth::user()->id,
                            'entry_date' => strtotime(date('Y-m-d')),
                        ]);

                        UserPrivMst::create([
                            'user_id' => $single_user,
                            'main_menu_id' => $cbo_sub_main_menu_name,
                            'show_priv' => 1,
                            'delete_priv' => 1,
                            'save_priv' => 1,
                            'edit_priv' => 1,
                            'approve_priv' => 1,
                            'valid' => 1,
                            'inserted_by' => Auth::user()->id,
                            'entry_date' => strtotime(date('Y-m-d')),
                        ]);

                        UserPrivMst::create([
                            'user_id' => $single_user,
                            'main_menu_id' => $cbo_sub_main_menu_name,
                            'show_priv' => $cbo_visibility,
                            'delete_priv' => $cbo_delete,
                            'save_priv' => $cbo_insert,
                            'edit_priv' => $cbo_edit,
                            'approve_priv' => $cbo_approve,
                            'valid' => 1,
                            'inserted_by' => Auth::user()->id,
                            'entry_date' => strtotime(date('Y-m-d')),
                        ]);
                    }
                    
                }
                else if ($cbo_main_menu_name!=0 && $cbo_sub_main_menu_name!=0)
                {
                    $nameArray2=sql_select( "SELECT * FROM main_menu WHERE sub_root_menu =$cbo_sub_main_menu_name AND m_module_id = $cbo_main_module and status=1");

                    execute_query( "delete from user_priv_mst where main_menu_id in ( select m_menu_id from main_menu where m_module_id=$cbo_main_module and sub_root_menu in ($cbo_sub_main_menu_name)) and user_id  in (".$cbo_user_name.")");
                    
                    execute_query( "delete from user_priv_mst where main_menu_id in ( select m_menu_id from main_menu where  m_module_id=$cbo_main_module ) and user_id in (".$cbo_user_name.") and main_menu_id=$cbo_main_menu_name");
                    
                    execute_query( "delete from user_priv_mst where main_menu_id in( select m_menu_id from main_menu where m_module_id=$cbo_main_module) and user_id in (".$cbo_user_name.") and main_menu_id=$cbo_sub_main_menu_name");

                    foreach($cbo_user_arr as $single_user)
                    {
                        $nameArray=sql_select( "SELECT * FROM user_priv_module WHERE user_id=".$single_user." AND module_id = $cbo_main_module" );
                        if (count($nameArray)<1)
                        {
                            UserPrivModule::create([
                                'user_id' => $single_user,
                                'module_id' => $cbo_main_module,
                                'valid' => 1
                            ]);
                        }
                        
                        UserPrivMst::create([
                            'user_id' => $single_user,
                            'main_menu_id' => $cbo_main_menu_name,
                            'show_priv' => 1,
                            'delete_priv' => $cbo_delete,
                            'save_priv' => $cbo_insert,
                            'edit_priv' => $cbo_edit,
                            'approve_priv' => $cbo_approve,
                            'valid' => 1,
                            'inserted_by' => Auth::user()->id,
                            'entry_date' => strtotime(date('Y-m-d')),
                        ]);
                        
                        $count=count($nameArray2);
                        $i=0;
                        if ($count>0)
                        {
                            UserPrivMst::create([
                                'user_id' => $single_user,
                                'main_menu_id' => $cbo_sub_main_menu_name,
                                'show_priv' => $cbo_visibility,
                                'delete_priv' => $cbo_delete,
                                'save_priv' => $cbo_insert,
                                'edit_priv' => $cbo_edit,
                                'approve_priv' => $cbo_approve,
                                'valid' => 1,
                                'inserted_by' => Auth::user()->id,
                                'entry_date' => strtotime(date('Y-m-d')),
                            ]);
                            foreach ($nameArray2 as $inf)
                            {
                                UserPrivMst::create([
                                    'user_id' => $single_user,
                                    'main_menu_id' => $inf[csf("m_menu_id")],
                                    'show_priv' => $cbo_visibility,
                                    'delete_priv' => $cbo_delete,
                                    'save_priv' => $cbo_insert,
                                    'edit_priv' => $cbo_edit,
                                    'approve_priv' => $cbo_approve,
                                    'valid' => 1,
                                    'inserted_by' => Auth::user()->id,
                                    'entry_date' => strtotime(date('Y-m-d')),
                                ]);
                            } 
                        }
                        else
                        {
                            UserPrivMst::create([
                                'user_id' => $single_user,
                                'main_menu_id' => $cbo_sub_main_menu_name,
                                'show_priv' => $cbo_visibility,
                                'delete_priv' => $cbo_delete,
                                'save_priv' => $cbo_insert,
                                'edit_priv' => $cbo_edit,
                                'approve_priv' => $cbo_approve,
                                'valid' => 1,
                                'inserted_by' => Auth::user()->id,
                                'entry_date' => strtotime(date('Y-m-d')),
                            ]);
                        }
                    }
                }
                else if ($cbo_main_menu_name != 0)
                {
                    //dd($cbo_main_menu_name);
                    $nameArray1=sql_select( "SELECT * FROM main_menu WHERE m_module_id = $cbo_main_module and root_menu=$cbo_main_menu_name and status=1");
                    //dd($cbo_user_arr);
                    execute_query( "delete from user_priv_mst where main_menu_id in( select m_menu_id from main_menu where m_module_id=$cbo_main_module and root_menu=$cbo_main_menu_name) and user_id in (".$cbo_user_name.")");
                    
                    execute_query( "delete from user_priv_mst where main_menu_id in ( select m_menu_id from main_menu where m_module_id=$cbo_main_module) and user_id in (".$cbo_user_name.") and main_menu_id=$cbo_main_menu_name");
                    foreach($cbo_user_arr as $single_user)
                    {
                        $nameArray=sql_select( "SELECT * FROM user_priv_module WHERE user_id in (".$single_user.") AND module_id = $cbo_main_module" );
                        if (count($nameArray)<1)
                        {
                            UserPrivModule::create([
                                'user_id' => $single_user,
                                'module_id' => $cbo_main_module,
                                'valid' => 1
                            ]);
                        }
                        
                        $count=count($nameArray1);
                        if ($count>0)
                        {
                            UserPrivMst::create([
                                'user_id' => $single_user,
                                'main_menu_id' => $cbo_main_menu_name,
                                'show_priv' => $cbo_visibility,
                                'delete_priv' => $cbo_delete,
                                'save_priv' => $cbo_insert,
                                'edit_priv' => $cbo_edit,
                                'approve_priv' => $cbo_approve,
                                'valid' => 1,
                                'inserted_by' => Auth::user()->id,
                                'entry_date' => strtotime(date('Y-m-d')),
                            ]);
                        
                            foreach ($nameArray1 as $inf)
                            {
                                UserPrivMst::create([
                                    'user_id' => $single_user,
                                    'main_menu_id' => $inf[csf("m_menu_id")],
                                    'show_priv' => $cbo_visibility,
                                    'delete_priv' => $cbo_delete,
                                    'save_priv' => $cbo_insert,
                                    'edit_priv' => $cbo_edit,
                                    'approve_priv' => $cbo_approve,
                                    'valid' => 1,
                                    'inserted_by' => Auth::user()->id,
                                    'entry_date' => strtotime(date('Y-m-d')),
                                ]);
                            } 
                        }
                        else
                        {
                            UserPrivMst::create([
                                'user_id' => $single_user,
                                'main_menu_id' => $cbo_main_menu_name,
                                'show_priv' => $cbo_visibility,
                                'delete_priv' => $cbo_delete,
                                'save_priv' => $cbo_insert,
                                'edit_priv' => $cbo_edit,
                                'approve_priv' => $cbo_approve,
                                'valid' => 1,
                                'inserted_by' => Auth::user()->id,
                                'entry_date' => strtotime(date('Y-m-d')),
                            ]);
                        }
                    }
                    
                }
            }
            DB::commit();
            //$module = MainModule::where('id',$request->update_id)->first();
            return response()->json(
                [
                    'user_id' => $single_user,
                    'main_menu_id' => $cbo_main_menu_name
                ]
            );
        }
        catch(Exception $e)
        {
            DB::rollBack();
            return response()->json($e->getMessage());
        }
    }

    public function copyUserPreviledge(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $user_name=str_replace("'","",$request->cbo_user_name);
            $cbo_main_module=str_replace("'","",$request->cbo_main_module);
            $copyuser_name_arr=explode(',',str_replace("'","",$request->cbo_copyuser_name));
            
            foreach($copyuser_name_arr as $copyuser_name)
            {
                execute_query( "delete from user_priv_module where user_id ='".$copyuser_name."' and module_id =  $cbo_main_module " );
                execute_query( "delete from user_priv_mst where user_id='".$copyuser_name."' and m_module_id = $cbo_main_module");
            
                $sqlPreModule = sql_select("select id, user_id, module_id, user_only, valid, entry_date from user_priv_module where user_id in($user_name) and module_id =  $cbo_main_module and valid=1");
                
                foreach($sqlPreModule as $rowmd)
                {
                    UserPrivModule::create([
                        'user_id' => $copyuser_name,
                        'module_id' => $rowmd[csf('module_id')],
                        'user_only' => $rowmd[csf('user_only')],
                        'valid' => $rowmd[csf('valid')],
                        'entry_date' => $rowmd[csf('entry_date')],
                    ]);
                }
            
                
                
                $sqlPreMst=sql_select("select id, user_id, main_menu_id, show_priv, delete_priv, save_priv, edit_priv, approve_priv, entry_date, user_only, last_updated_by, inserted_by, last_update_date, valid from user_priv_mst where user_id in($user_name) and m_module_id = $cbo_main_module and valid=1");
               
                foreach($sqlPreMst as $rowmst)
                {
                    UserPrivMst::create([
                        'user_id' => $copyuser_name,
                        'main_menu_id' => $rowmst[csf('main_menu_id')],
                        'show_priv' => $rowmst[csf('show_priv')],
                        'delete_priv' => $rowmst[csf('delete_priv')],
                        'save_priv' => $rowmst[csf('save_priv')],
                        'edit_priv' => $rowmst[csf('edit_priv')],
                        'approve_priv' => $rowmst[csf('approve_priv')],
                        'last_updated_by' => $rowmst[csf('last_updated_by')],
                        'inserted_by' => Auth::user()->id,
                        'entry_date' => $rowmst[csf('entry_date')],
                        'user_only' => $rowmst[csf('user_only')],
                        'last_update_date' => $rowmst[csf('last_update_date')],
                        'valid' => $rowmst[csf('valid')]
                    ]);
                }
            }
            DB::commit();
            return response()->json(
                [
                    'user_id' => $user_name,
                    'response_no' => 0
                ]
            );
        }
        catch(Exception $e)
        {
            DB::rollBack();
            return response()->json($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(UserPrivMst $userPrivMst)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserPrivMst $userPrivMst)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserPrivMstRequest $request, UserPrivMst $userPrivMst)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserPrivMst $userPrivMst)
    {
        //
    }
    public function load_priviledge_list(Request $request)
    {
        $data = $request->query('data') ?? 0;
        return view('tools.load_priviledge_list',compact('data'));
    }
    public function load_priv_list_view(Request $request)
    {
        $data = $request->query('data') ?? 0;
        return view('ajax.load_priv_list_view',compact('data'));
    }
}
