{^include file=$comheader_file^}
<script type="text/javascript">
$(document).ready(function(){
    $("button.type_switch_button").click(function(){
        var target_type_id = $(this).val();
        $("button.type_switch_button").removeClass("ui-btn-b");
        $(this).addClass("ui-btn-b");
        $("#custom_vehicle_type").val(target_type_id);
        $(".new_package_box").each(function(){
            if (!$(this).hasClass("no_disp")) {
                $(this).addClass("no_disp");
            }
        });
        $("div#new_package_" + target_type_id).removeClass("no_disp");
    });
});
</script>
<form action="./" method="get" data-ajax="false">
  <input type="hidden" name="menu" value="{^$current_menu^}" />
  <input type="hidden" name="act" value="{^$current_act^}" />
{^if $edit_mode^}
  <input type="hidden" name="edit" value="{^$custom_id^}" />
{^/if^}
  <div class="ui-corner-all custom-corners">
    <div class="ui-bar ui-bar-a ta_c">
      <h1>会员详细</h1>
    </div>
    <div class="ui-body ui-body-a">
      <div class="ui-field-contain">
        <label for="custom_name">会员名</label>
        <input type="text" name="custom_info[custom_name]" value="{^$custom_card_info["custom_name"]^}" id="custom_name" />
      </div>
{^if isset($user_err_list["custom_name"])^}
      <p class="fc_red">{^$user_err_list["custom_name"]^}</p>
{^/if^}
      <div class="ui-field-contain">
        <label for="card_id">会员卡号</label>
        <input type="text" name="custom_info[card_id]" value="{^$custom_card_info["card_id"]^}" id="card_id" />
      </div>
{^if isset($user_err_list["card_id"])^}
      <p class="fc_red">{^$user_err_list["card_id"]^}</p>
{^/if^}
      <div class="ui-field-contain">
        <label for="custom_mobile">手机号码</label>
        <input type="text" name="custom_info[custom_mobile]" value="{^$custom_card_info["custom_mobile"]^}" id="custom_mobile" />
      </div>
{^if isset($user_err_list["custom_mobile"])^}
      <p class="fc_red">{^$user_err_list["custom_mobile"]^}</p>
{^/if^}
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
{^if isset($user_err_list["custom_plate"])^}
      <p class="fc_red">{^$user_err_list["custom_plate"]^}</p>
{^/if^}
      <div class="ui-field-contain">
        <fieldset data-role="controlgroup" data-type="horizontal" data-mini="true">
          <legend>车辆类型</legend>
{^foreach from=$vehicle_type_list key=vehicle_key item=vehicle_item^}
          <button type="button" class="ui-shadow ui-btn ui-corner-all type_switch_button{^if $vehicle_key eq $custom_card_info["custom_vehicle_type"]^} ui-btn-b{^/if^}" value="{^$vehicle_key^}"{^if $edit_mode^} disabled{^/if^}>{^$vehicle_item^}</button>
{^/foreach^}
        </fieldset>
      </div>
      <input type="hidden" name="custom_info[custom_vehicle_type]" value="{^$custom_card_info["custom_vehicle_type"]^}" id="custom_vehicle_type" />
    </div>
  </div>
  <h1></h1>
{^if !$edit_mode^}
  <div class="ui-corner-all custom-corners">
    <div class="ui-bar ui-bar-a ta_c">
      <h1>套餐详细</h1>
    </div>
    <div class="ui-body ui-body-a">
{^foreach from=$usable_package_list key=vehicle_type_key item=package_list^}
      <div class="new_package_box{^if $custom_card_info["custom_vehicle_type"] neq $vehicle_type_key^} no_disp{^/if^}" id="new_package_{^$vehicle_type_key^}">
        <fieldset data-role="controlgroup">
{^foreach from=$package_list key=package_id item=package_item^}
          <input type="radio" name="package_info[{^$vehicle_type_key^}]" value="{^$package_id^}" id="package_id_{^$vehicle_type_key^}_{^$package_id^}"{^if $package_id eq $custom_card_info["card_package"]^} checked{^/if^} />
          <label for="package_id_{^$vehicle_type_key^}_{^$package_id^}">{^$package_item["p_price"]|string_format:"%d"^}元/{^if $package_item["p_infinity_flg"]^}无限{^else^}{^$package_item["p_times"]^}{^/if^}次{^if $package_item["p_special_flg"]^}(优惠活动){^/if^}</label>
{^/foreach^}
        </fieldset>
      </div>
{^/foreach^}
    </div>
  </div>
{^/if^}
  <button type="submit" name="do_submit" value="1" class="ui-shadow ui-btn ui-corner-all ui-btn-b">确认</button>
</form>
{^include file=$comfooter_file^}
