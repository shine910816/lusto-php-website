{^include file=$comheader_file^}
<div class="ui-corner-all custom-corners">
  <div class="ui-bar ui-bar-a ta_c">
    <h1>会员详细</h1>
  </div>
  <div class="ui-body ui-body-a">
    <table data-role="table" data-mode="columntoggle:none" class="ui-responsive fall_table">
      <tbody>
        <tr>
          <th>会员卡号</th>
          <td>{^$custom_info["card_id"]^}</td>
        </tr>
        <tr>
          <th>姓名</th>
          <td>{^$custom_info["custom_name"]^}</td>
        </tr>
        <tr>
          <th>手机号码</th>
          <td>{^$custom_info["custom_mobile"]^}</td>
        </tr>
        <tr>
          <th>车牌照号</th>
          <td>{^if $custom_info["custom_plate"]^}{^$plate_region_list[$custom_info["custom_plate_region"]]^}{^$custom_info["custom_plate"]^}{^/if^}</td>
        </tr>
        <tr>
          <th>车型</th>
          <td>{^$vehicle_type_list[$custom_info["custom_vehicle_type"]]^}</td>
        </tr>
      </tbody>
    </table>
    <a href="./?menu=custom&act=input&edit={^$custom_id^}" class="ui-shadow ui-btn ui-corner-all ui-btn-a" data-ajax="false">编辑信息</a>
  </div>
</div>
<h1></h1>
<div class="ui-corner-all custom-corners">
  <div class="ui-bar ui-bar-a ta_c">
    <h1>套餐余额</h1>
  </div>
  <div class="ui-body ui-body-a">
    <table data-role="table" data-mode="columntoggle:none" class="ui-responsive fall_table">
      <tbody>
        <tr>
          <th>会员卡类型</th>
          <td>{^if $custom_info["card_usable_infinity_flg"]^}年{^else^}次{^/if^}卡</td>
        </tr>
        <tr>
          <th>{^if $custom_info["card_usable_infinity_flg"]^}有效期限{^else^}剩余次数{^/if^}</th>
          <td>{^$surplus_text^}</td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
<h1></h1>
<div class="ui-corner-all custom-corners">
  <div class="ui-bar ui-bar-a ta_c">
    <h1>充值记录</h1>
  </div>
  <div class="ui-body ui-body-a">
    <table data-role="table" data-mode="columntoggle:none" class="ui-responsive disp_table">
      <thead>
        <tr>
          <th>类型</th>
          <th>日期</th>
          <th>金额</th>
          <th>{^if $custom_info["card_usable_infinity_flg"]^}有效期{^else^}次数{^/if^}</th>
        </tr>
      </thead>
      <tbody>
{^foreach from=$invest_info item=invest_item^}
        <tr>
          <td>{^if $invest_item["card_order_id"] eq "1"^}开卡{^else^}充值{^/if^}</td>
          <td>{^$invest_item["insert_date"]|date_format:"%Y-%m-%d"^}</td>
          <td>{^$invest_item["card_price"]^}</td>
          <td>{^if $custom_info["card_usable_infinity_flg"]^}{^$invest_item["card_expire"]|date_format:"%Y-%m-%d"^}{^else^}{^$invest_item["card_usable_count"]^}次{^/if^}</td>
        </tr>
{^/foreach^}
      </tbody>
    </table>
  </div>
</div>
{^if !empty($change_history)^}
<h1></h1>
<div class="ui-corner-all custom-corners">
  <div class="ui-bar ui-bar-a ta_c">
    <h1>会员信息修改历史</h1>
  </div>
  <div class="ui-body ui-body-a">
    <table data-role="table" data-mode="columntoggle:none" class="ui-responsive disp_table">
      <thead>
        <tr>
          <th>修改日期</th>
          <th>修改内容</th>
          <th>修改前</th>
          <th>修改后</th>
        </tr>
      </thead>
      <tbody>
{^foreach from=$change_history item=change_item^}
        <tr>
          <td>{^$change_item["insert_date"]|date_format:"%Y-%m-%d"^}</td>
          <td>{^$change_type_list[$change_item["change_type"]]^}</td>
          <td>{^$change_item["change_from"]^}</td>
          <td>{^$change_item["change_to"]^}</td>
        </tr>
{^/foreach^}
      </tbody>
    </table>
  </div>
</div>
{^/if^}
{^include file=$comfooter_file^}
