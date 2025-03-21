<?php
    $data = json_decode($data,true);
    
    $company_id = $data['company_id'];
    $on_change = $data['onchange'] ?? '';
    
    $lib_location = App\Models\LibLocation::where('company_id',$company_id)->pluck('location_name', 'id');
?>
<select name="cbo_location_name" id="cbo_location_name"  class="form-control" onchange="<?php echo $on_change;?>">
    <option value="0">SELECT</option>
    @foreach($lib_location as $id => $location_name)
        <option value="{{ $id }}">{{ $location_name }}</option>
    @endforeach
</select>