<select name="cbo_root_menu_under" id="cbo_root_menu_under" class="form-control" >
    <option value="0">SELECT</option>
    @foreach($sub_menus as $menu)
        <option value="{{$menu->m_menu_id}}" >{{$menu->menu_name}}</option>
    @endforeach
</select>