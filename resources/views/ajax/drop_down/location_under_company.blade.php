<?php
    $data = explode("*",$data);
    $company_id = $data[0];
    $is_loaded = "";
    $on_change = "";
    if(count($data) > 1)
    {
        $is_loaded = $data[1];
    }
    if(!empty($is_loaded))
    {
       $on_change ="load_drop_down('load_drop_down',this.value, '".$data[1]."', '".$data[2]."' )" ;
    }
    $lib_location = App\Models\LibLocation::where('company_id',$company_id)->pluck('location_name', 'id');
?>
<select name="cbo_location_name" id="cbo_location_name"  class="form-control" onchange="<?php echo $on_change;?>">
    <option value="0">SELECT</option>
    @foreach($lib_location as $id => $location_name)
        <option value="{{ $id }}">{{ $location_name }}</option>
    @endforeach
</select>