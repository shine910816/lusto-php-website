{^include file=$comheader_file^}
<div class="ui-corner-all custom-corners">
  <div class="ui-bar ui-bar-a ta_c">
    <h1>会员详细</h1>
  </div>
  <div class="ui-body ui-body-a">
    <form>
      <input type="hidden" name="menu" value="{^$current_menu^}" />
      <input type="hidden" name="act" value="{^$current_act^}" />
{^if $edit_mode^}
      <input type="hidden" name="edit" value="{^$custom_id^}" />
{^/if^}
      <div class="ui-field-contain">
        <label for="custom_name">会员名</label>
        <input type="text" name="custom_info[custom_name]" value="{^$custom_card_info["custom_name"]^}" id="custom_name" />
      </div>
      <div class="ui-field-contain">
        <label for="card_id">会员卡号</label>
        <input type="text" name="custom_info[card_id]" value="{^$custom_card_info["card_id"]^}" id="card_id" />
      </div>
      <div class="ui-field-contain">
        <label for="custom_mobile">手机号码</label>
        <input type="text" name="custom_info[custom_mobile]" value="{^$custom_card_info["custom_mobile"]^}" id="custom_mobile" />
      </div>


      <div class="ui-field-contain">
        <label for="custom_plate_region">车牌号码</label>
        <select name="custom_info[custom_plate_region]" id="custom_plate_region" data-inline="true">
{^foreach from=$plate_region_list key=region_key item=region_item^}
          <option value="{^$region_key^}"{^if $region_key eq $custom_card_info["custom_plate_region"]^} selected{^/if^}>{^$region_item^}</option>
{^/foreach^}
        </select>
      </div>
      <div class="ui-field-contain">
        <label for="custom_plate">&nbsp;</label>
        <input type="text" name="custom_info[custom_plate]" value="{^$custom_card_info["custom_plate"]^}" id="custom_plate" style="text-transform:uppercase;" />
      </div>
      <div class="ui-field-contain">
        <fieldset data-role="controlgroup" data-type="horizontal">
          <legend>车辆类型</legend>
{^foreach from=$vehicle_type_list key=vehicle_key item=vehicle_item^}
          <input type="radio" name="custom_vehicle_type" id="vehicle_type_{^$vehicle_key^}"{^if $vehicle_key eq $custom_card_info["custom_vehicle_type"]^} checked{^/if^}{^if $edit_mode^} disabled{^/if^} />
          <label for="vehicle_type_{^$vehicle_key^}">{^$vehicle_item^}</label>
{^/foreach^}
        </fieldset>
      </div>
    </form>
  </div>
</div>
{^include file=$comfooter_file^}
