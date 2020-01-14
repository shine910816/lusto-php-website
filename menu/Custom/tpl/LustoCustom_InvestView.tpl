{^include file=$comheader_file^}
<script type="text/javascript">
$(document).ready(function(){
    $("#search_card_id").select();
    $("#search_card_id").keyup(function(){
        var ajax_url = "./?menu=custom&act=invest&get_data=" + $(this).val();
        $.get(ajax_url, function(data){
            var json = eval("(" + data + ")");
            if (json.error == "1") {
                if (!$("#custom_info_form").hasClass("no_disp")) {
                    $("#custom_info_form").addClass("no_disp");
                }
                $("input[name='custom_id']").val("");
                $("td.custom_info_td").empty();
                $("#package_list").empty();
            } else {
                $("input[name='custom_id']").val(json.result.custom_id);
                $("td#card_type").html(json.result.card_type);
                $("td#custom_mobile").html(json.result.custom_mobile);
                $("td#custom_name").html(json.result.custom_name);
                $("td#custom_plate").html(json.result.custom_plate);
                $("td#custom_vehicle_type").html(json.result.custom_vehicle_type);
                var package_context = "";
                $.each(json.result.list, function(idx, val) {
                    package_context += '<option value="' + idx + '">' + val + '</option>';
                });
                $("#package_list").html(package_context);
                $("#package_list").selectmenu("refresh");
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
    <h1>续费充值</h1>
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
      </tbody>
    </table>
  </div>
</div>
<h1></h1>
<div class="ui-corner-all custom-corners">
  <div class="ui-bar ui-bar-a ta_c">
    <h1>套餐选择</h1>
  </div>
  <div class="ui-body ui-body-a">
    <fieldset class="ui-grid-a">
      <div class="ui-block-a"><select name="package_id" id="package_list"></select></div>
      <div class="ui-block-b"><button name="do_invest" value="1" class="ui-shadow ui-btn ui-corner-all ui-btn-b">充值</button></div>
    </fieldset>
  </div>
</div>
</form>
{^include file=$comfooter_file^}
