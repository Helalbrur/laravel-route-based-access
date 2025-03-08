
<?php
    $data = explode("**", $data);

    $menu_id = $data[0];
    $menu_link = $data[1];
    //dd(get_available_route($menu_id));
?>
<select name="txt_menu_link" id="txt_menu_link" class="form-control select2">
    <option value="">Select a Route</option>
    @foreach(get_available_route($menu_id) as $route)
        <option value="{{ $route }}" {{$menu_link == $route ? 'selected' : ''}}>{{ $route }}</option>
    @endforeach
</select>