<?php

namespace App\Http\Controllers;

use App\Models\MainMenu;
use Illuminate\Http\Request;
use App\Http\Requests\StoreMainMenuRequest;
use App\Http\Requests\UpdateMainMenuRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;
class MainMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $menu_id = $request->query('mid') ?? 0;
        $permission = getPagePermission($menu_id);
        return view('tools.create_menu',compact('permission'));
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
            $mainMenu=MainMenu::orderBy('m_menu_id','DESC')->first();
            $m_menu_id=1;
            if(!empty($mainMenu->m_menu_id))
            {
                $m_menu_id=$mainMenu->m_menu_id + 1;
            }
            else if(!empty($mainMenu->id))
            {
                $m_menu_id=$mainMenu->id + 1;
            }

            if( str_replace("'","",$request->cbo_root_menu) == 0 ) {
                $position = 1;
            }
            else {
                if( str_replace("'","",$request->cbo_root_menu_under) == 0 ) $position = 2;
                else $position = 3;
            }
            $mainMenu=MainMenu::create([
                'm_module_id'=>$request->cbo_module_name,
                'root_menu'=>$request->cbo_root_menu,
                'sub_root_menu'=>$request->cbo_root_menu_under ?? '',
                'menu_name'=>$request->txt_menu_name,
                'm_menu_id'=>$m_menu_id,
                'f_location'=>$request->txt_menu_link ?? '',
                'position'=>$position,
                'status'=>$request->cbo_menu_sts,
                'slno'=>$request->txt_menu_seq,
                'report_menu'=>$request->chk_report_menu,
                'fabric_nature'=>$request->cbo_fabric_nature,
                'is_mobile_menu'=>$request->chk_mobile_menu,
                'm_page_name'=>$request->txt_page_link,
                'm_page_short_name'=>$request->txt_short_name,
                'inserted_by'=>Auth::user()->id,
                'status_active'=>1,
                'is_deleted'=>0
            ]);
            DB::commit();
            //$module = MainModule::where('id',$request->update_id)->first();
            return response()->json(
                $mainMenu
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
    public function show(MainMenu $mainMenu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MainMenu $mainMenu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $menu_id)
    {
        DB::beginTransaction();
        try
        {
           
            $menu = MainMenu::where('m_menu_id',$menu_id)->first();

            if( str_replace("'","",$request->cbo_root_menu) == 0 ) {
                $position = 1;
            }
            else {
                if( str_replace("'","",$request->cbo_root_menu_under) == 0 ) $position = 2;
                else $position = 3;
            }
            $menu=$menu->update([
                'm_module_id'=>$request->cbo_module_name,
                'root_menu'=>$request->cbo_root_menu,
                'sub_root_menu'=>$request->cbo_root_menu_under ?? '',
                'menu_name'=>$request->txt_menu_name,
                'f_location'=>$request->txt_menu_link ?? '',
                'position'=>$position,
                'status'=>$request->cbo_menu_sts,
                'slno'=>$request->txt_menu_seq,
                'report_menu'=>$request->chk_report_menu,
                'fabric_nature'=>$request->cbo_fabric_nature,
                'is_mobile_menu'=>$request->chk_mobile_menu,
                'm_page_name'=>$request->txt_page_link,
                'm_page_short_name'=>$request->txt_short_name,
                'inserted_by'=>Auth::user()->id,
                'status_active'=>1,
                'is_deleted'=>0
            ]);
            DB::commit();
            //$module = MainModule::where('id',$request->update_id)->first();
            return response()->json(
                $menu
            );
        }
        catch(Exception $e)
        {
            DB::rollBack();
            return response()->json($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MainMenu $mainMenu)
    {
        //
    }
    public function create_menu_search_list_view(Request $request)
    {
        $data = $request->query('data') ?? 0;
        $data=explode('_',$data);
        if ($data[0]!='') $menu_name="%".strtolower($data[0])."%"; else $menu_name="%%";
        if ($data[1]!=0) $m_module_id="$data[1]"; else $m_module_id="";
        if($data[1]==0)
        {
            echo "<b>Select Main Module Name then Enter Menu Name </b>";
            die;
        }
        else
        {
            $sql= "select m_menu_id,m_module_id,menu_name,root_menu,sub_root_menu,position,fabric_nature,slno from main_menu  where lower(menu_name) like '$menu_name' and m_module_id='$m_module_id' and status !=0 and status_active=1 and is_deleted=0 order by root_menu,sub_root_menu,slno ASC";
            $result = sql_select($sql);
            $menu_sub_menu_ids = array();
            foreach($result as $row)
            {
                if(!empty($row[csf('root_menu')]))
                {
                    $menu_sub_menu_ids[$row[csf('root_menu')]] = $row[csf('root_menu')];
                }
                else if(!empty($row[csf('sub_root_menu')]))
                {
                    $menu_sub_menu_ids[$row[csf('sub_root_menu')]] = $row[csf('sub_root_menu')];
                }
            }
           //echo $sql;die;
            $m_module_id=return_library_array( "select m_mod_id, main_module from main_module",'m_mod_id','main_module');
            $main_menu_arr= array();
            if(count($menu_sub_menu_ids))
            {
                $main_menu_arr=return_library_array( "select m_menu_id, menu_name from main_menu where m_menu_id in (".implode(",",$menu_sub_menu_ids).")",'m_menu_id','menu_name');
            }
            
            $arr=array (1=>$m_module_id,3=>$main_menu_arr,4=>$main_menu_arr,5=>get_item_category());
            //print_r( get_item_category());
            echo  create_list_view ( "list_view", "ID,Module Name,Menu Name,Root Menu,Sub Root Menu,Fabric Nature,Position,Seq.", "60,100,150,100,100,75,50,50","720","300",1, $sql, "load_php_data_to_form", "m_menu_id","", 1, "0,m_module_id,0,root_menu,sub_root_menu,fabric_nature,0,0", $arr , "m_menu_id,m_module_id,menu_name,root_menu,sub_root_menu,fabric_nature,position,slno", "tools/create_menu/get_data_by_id", 'setFilterGrid("list_view",-1);',"0,0,0,0,1,0,1,1" ) ;
        }
        exit();
    }
    public function get_data_by_id($id)
    {
        try
        {
            $menu = MainMenu::where('m_menu_id',$id)->first();
            return response()->json(
                [
                    'm_menu_id' => $menu->m_mod_id,
                    'm_module_id'=>$menu->m_module_id,
                    'root_menu'=>$menu->root_menu,
                    'sub_root_menu'=>$menu->sub_root_menu,
                    'menu_name'=>$menu->menu_name,
                    'id'=>$menu->id,
                    'f_location'=>$menu->f_location,
                    'fabric_nature'=>$menu->fabric_nature,
                    'position'=>$menu->position,
                    'status'=>$menu->status,
                    'slno'=>$menu->slno,
                    'report_menu'=>$menu->report_menu,
                    'is_mobile_menu'=>$menu->is_mobile_menu,
                    'm_page_name'=>$menu->m_page_name,
                    'm_page_short_name'=>$menu->m_page_short_name
                ]
            );

        }
        catch(Exception $e)
        {
            return response()->json($e->getMessage());
        }
    }

    function root_menu_under(Request $request)
    {
        $data = $request->query('data') ?? '';
        $data = explode("_",$data);
        $root_menu = $data[0] ?? 0;
        $width = $data[1] ?? 165;
        echo create_drop_down( "cbo_root_menu_under", $width, "select m_menu_id,menu_name from main_menu where position='2' and root_menu ='$root_menu' order by menu_name","m_menu_id,menu_name", 1, "-- Select Menu Name --", 0, "load_drop_down( 'tools/sub_root_menu_under', this.value, 'sub_root_menu_under', 'sub_subrootdiv' )" );
	    exit();
    }
    function sub_root_menu_under(Request $request)
    {
        $data = $request->query('data') ?? '';
        $data = explode("_",$data);
        $sub_root_menu = $data[0] ?? 0;
        $width = $data[1] ?? 165;
        echo create_drop_down( "cbo_sub_menu_name", $width, "select m_menu_id,menu_name from main_menu where position='3' and sub_root_menu='$sub_root_menu' and status=1 and status_active=1 and is_deleted=0 order by m_menu_id","m_menu_id,menu_name", 1, "-- Select Sub Menu --", 0 , "" );
        exit();
    }

    function load_main_menu(Request $request)
    {
        $data = $request->query('data') ?? '';
        $data = explode("_",$data);
        $module_id = $data[0] ?? 0;
        $menus = DB::table('main_menu')->where('m_module_id',$module_id)->where('position',1)->orderBy('menu_name','asc')->get();
        return view('ajax.load_main_menu',compact('menus'));
        
    }
    function load_sub_menu_under_menu(Request $request)
    {
        $data = $request->query('data') ?? '';
        $data = explode("_",$data);
        $root_menu = $data[0] ?? 0;
        $sub_menus = DB::table('main_menu')->where('root_menu',$root_menu)->where('position',2)->orderBy('menu_name','asc')->get();
        return view('ajax.sub_root_menu_under',compact('sub_menus'));
        exit();
    }
}
