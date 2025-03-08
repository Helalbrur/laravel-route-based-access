<select name="cbo_root_menu" id="cbo_root_menu" class="form-control" onchange="load_drop_down( 'tools/load_sub_menu_under_menu', this.value, 'tools/load_sub_menu_under_menu', 'subrootdiv' )">
    <option value="0">SELECT</option>
    @foreach($menus as $menu)
        <option value="{{$menu->m_menu_id}}" >{{$menu->menu_name}}</option>
    @endforeach
</select>