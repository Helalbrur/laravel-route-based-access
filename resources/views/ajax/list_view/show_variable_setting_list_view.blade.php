<?php

use App\Models\VariableSetting;

$data = json_decode($param,true);
$company_name = $data['company_name'];
$variable_name = $data['variable_name'];
$permission = $data['permission'];

?>
@if($variable_name == 1)
    <?php
    $setting  = VariableSetting::where('company_id',$company_name)->where('variable_id',$variable_name)->first();
    // dd($setting);
    ?>

    <div class="form-group row">
        <label for="cbo_variable_name" class="col-sm-3 col-form-label must_entry_caption">Is Item Code System Generated ? </label>
        <div class="col-sm-6" >
            <?php
                $yes_no_arr = yes_no();
                ?>
            <select name="cbo_variable_value" id="cbo_variable_value"   class="form-control">
                <option value="0">SELECT</option>
                @foreach($yes_no_arr as $yes_no_id => $yes_no_value)
                    <option value="{{$yes_no_id}}" @if(!empty($setting) && !empty($setting->variable_value)) {{$setting->variable_value == $yes_no_id ? 'selected' : ''}} @endif>{{$yes_no_value}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="from-group row" style="margin-top: 20px;">
        <div class="col-sm-12">
            <input type="hidden" value="{{$setting->id ?? ''}}" name="update_id" id="update_id" />
        
            <?php
                if(!empty($setting) && !empty($setting->id))
                {
                    $is_update = 1;
                }
                else
                {
                    $is_update = 0;
                }
                echo load_submit_buttons( $permission, "fnc_variable_setting", $is_update,0 ,"reset_form('variablesetting_1','','',1,'')");
            ?>
        </div>
    </div>
@endif 

@if($variable_name == 2)
    <?php
    $setting  = VariableSetting::where('company_id',$company_name)->where('variable_id',$variable_name)->first();
    // dd($setting);
    ?>

    <div class="form-group row">
        <label for="cbo_variable_name" class="col-sm-3 col-form-label must_entry_caption">Can Issue Exceed Requisition ? </label>
        <div class="col-sm-6" >
            <?php
                $yes_no_arr = yes_no();
                ?>
            <select name="cbo_variable_value" id="cbo_variable_value"   class="form-control">
                <option value="0">SELECT</option>
                @foreach($yes_no_arr as $yes_no_id => $yes_no_value)
                    <option value="{{$yes_no_id}}" @if(!empty($setting) && !empty($setting->variable_value)) {{$setting->variable_value == $yes_no_id ? 'selected' : ''}} @endif>{{$yes_no_value}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="from-group row" style="margin-top: 20px;">
        <div class="col-sm-12">
            <input type="hidden" value="{{$setting->id ?? ''}}" name="update_id" id="update_id" />
        
            <?php
                if(!empty($setting) && !empty($setting->id))
                {
                    $is_update = 1;
                }
                else
                {
                    $is_update = 0;
                }
                echo load_submit_buttons( $permission, "fnc_variable_setting", $is_update,0 ,"reset_form('variablesetting_1','','',1,'')");
            ?>
        </div>
    </div>
@endif 

@if($variable_name == 3)
    <?php
    $setting = VariableSetting::where('company_id', $company_name)->where('variable_id', $variable_name)->first();
    ?>
    <div class="form-group row">
        <label for="txt_over_receive" class="col-sm-3 col-form-label must_entry_caption">Over Receive %</label>
        <div class="col-sm-6">
            <input type="text" name="txt_over_receive" id="txt_over_receive" class="form-control" value="{{ optional($setting)->over_receive }}">
        </div>
    </div>
    <div class="form-group row">
        <label for="cbo_variable_name" class="col-sm-3 col-form-label must_entry_caption">Control</label>
        <div class="col-sm-6">
            <?php
            $yes_no_arr = yes_no();
            ?>
            <select name="cbo_variable_value" id="cbo_variable_value" class="form-control">
                <option value="0">SELECT</option>
                @foreach($yes_no_arr as $yes_no_id => $yes_no_value)
                    <option value="{{ $yes_no_id }}" @if(!empty($setting) && !empty($setting->variable_value)) {{ $setting->variable_value == $yes_no_id ? 'selected' : '' }} @endif>{{ $yes_no_value }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="from-group row" style="margin-top: 20px;">
        <div class="col-sm-12">
            <input type="hidden" value="{{ optional($setting)->id }}" name="update_id" id="update_id" />
            <?php
            if (!empty($setting) && !empty($setting->id)) {
                $is_update = 1;
            } else {
                $is_update = 0;
            }
            echo load_submit_buttons($permission, "fnc_variable_setting", $is_update, 0, "reset_form('variablesetting_1','','',1,'')");
            ?>
        </div>
    </div>
@endif 