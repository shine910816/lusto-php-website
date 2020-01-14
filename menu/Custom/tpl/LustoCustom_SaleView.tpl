{^include file=$comheader_file^}
<script type="text/javascript">
$(document).ready(function(){
    $("#search_card_id").select();
    $("#search_card_id").keyup(function(){
        var ajax_url = "./?menu=custom&act=sale&get_data=" + $(this).val();
        $.get(ajax_url, function(data){
            var json = eval("(" + data + ")");
            if (json.error == "1") {
                if (!$("#custom_info_form").hasClass("no_disp")) {
                    $("#custom_info_form").addClass("no_disp");
                }
                $("input[name='custom_id']").val("");
                $(".custom_info_td").empty();
                if (!$("button[name='do_sale']").hasClass("no_disp")) {
                    $("button[name='do_sale']").addClass("no_disp");
                }
            } else {
                $("input[name='custom_id']").val(json.result.custom_id);
                $("td#card_type").html(json.result.card_type);
                $("td#custom_mobile").html(json.result.custom_mobile);
                $("td#custom_name").html(json.result.custom_name);
                $("td#custom_plate").html(json.result.custom_plate);
                $("td#custom_vehicle_type").html(json.result.custom_vehicle_type);
                $("th#surplus_key").html(json.result.surplus_key);
                $("td#surplus_value").html(json.result.surplus_value);
                if (json.result.card_usable == "1") {
                    if ($("button[name='do_sale']").hasClass("no_disp")) {
                        $("button[name='do_sale']").removeClass("no_disp");
                    }
                } else {
                    if (!$("button[name='do_sale']").hasClass("no_disp")) {
                        $("button[name='do_sale']").addClass("no_disp");
                    }
                }
                if ($("#custom_info_form").hasClass("no_disp")) {
                    $("#custom_info_form").removeClass("no_disp");
                }
            }
        });
    });
});
</script>
<div class="ui-corner-all custom-corners">
  <div class="ui-bar ui-bar-a ta_c">
    <h1>洗车消费</h1>
  </div>
  <div class="ui-body ui-body-a">
    <div class="ui-field-contain">
      <label for="search_card_id">会员卡号</label>
      <input type="text" id="search_card_id" />
    </div>
  </div>
</div>
<form action="./" method="post" data-ajax="false" id="custom_info_form" class="no_disp">
<input type="hidden" name="menu" value="{^$current_menu^}" />
<input type="hidden" name="act" value="{^$current_act^}" />
<input type="hidden" name="custom_id" value="" />
<h1></h1>
<div class="ui-corner-all custom-corners">
  <div class="ui-bar ui-bar-a ta_c">
    <h1>会员信息</h1>
  </div>
  <div class="ui-body ui-body-a">
    <table data-role="table" data-mode="columntoggle:none" class="ui-responsive fall_table">
      <tbody>
        <tr>
          <th>会员卡类型</th>
          <td class="custom_info_td" id="card_type"></td>
        </tr>
        <tr>
          <th>会员姓名</th>
          <td class="custom_info_td" id="custom_name"></td>
        </tr>
        <tr>
          <th>手机号码</th>
          <td class="custom_info_td" id="custom_mobile"></td>
        </tr>
        <tr>
          <th>车牌照号</th>
          <td class="custom_info_td" id="custom_plate"></td>
        </tr>
        <tr>
          <th>车型</th>
          <td class="custom_info_td" id="custom_vehicle_type"></td>
        </tr>
        <tr>
          <th class="custom_info_td" id="surplus_key"></th>
          <td class="custom_info_td" id="surplus_value"></td>
        </tr>
      </tbody>
    </table>
    <button name="do_sale" value="1" class="ui-shadow ui-btn ui-corner-all ui-btn-b no_disp">洗车结算</button>
  </div>
</div>
</form>
{^include file=$comfooter_file^}
