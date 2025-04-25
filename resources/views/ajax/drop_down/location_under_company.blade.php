<?php
    $data = json_decode($data,true);
    
    $company_id = $data['company_id'];
    $on_change = $data['onchange'] ?? '';
    $row_id = $data['row_id'] ?? '';

    $name_extra = "";
    if(!empty($row_id))
    {
        $name_extra = "_".$row_id;
    }
    
    $lib_location = App\Models\LibLocation::where('company_id',$company_id)->pluck('location_name', 'id');
?>
<select name="cbo_location_name{{ $name_extra }}" id="cbo_location_name{{ $name_extra }}"  class="form-control" onchange="<?php echo $on_change;?>">
    <option value="0">SELECT</option>
    @foreach($lib_location as $id => $location_name)
        <option value="{{ $id }}">{{ $location_name }}</option>
    @endforeach
</select>