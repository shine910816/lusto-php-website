{^include file=$comheader_file^}
<div class="ui-corner-all custom-corners">
  <div class="ui-bar ui-bar-a ta_c">
    <h1>会员一览</h1>
  </div>
  <div class="ui-body ui-body-a">
    <fieldset class="ui-grid-a">
      <div class="ui-block-a"><a href="./?menu={^$current_menu^}&act={^$current_act^}" class="ui-shadow ui-btn ui-corner-all ui-btn-{^if $card_type_flg^}a{^else^}b{^/if^}" data-ajax="false">次卡用户</a></div>
      <div class="ui-block-b"><a href="./?menu={^$current_menu^}&act={^$current_act^}&year_card=1" class="ui-shadow ui-btn ui-corner-all ui-btn-{^if $card_type_flg^}b{^else^}a{^/if^}" data-ajax="false">年卡用户</a></div>
    </fieldset>
{^if !empty($custom_list)^}
    <table data-role="table" data-mode="columntoggle:none" class="ui-responsive disp_table">
      <thead>
        <tr>
          <th style="width:20%;" class="first_th">会员卡号</th>
          <th style="width:40%;">会员姓名</th>
          <th style="width:40%;">{^if $card_type_flg^}有效期{^else^}剩余次数{^/if^}</th>
        </tr>
      </thead>
      <tbody>
{^foreach from=$custom_list key=custom_id item=custom_item^}
        <tr>
          <td>{^$custom_item["card_id"]^}</td>
          <td>{^$custom_item["custom_name"]^}</td>
          <td{^if !$custom_item["active"]^} class="fc_red"{^/if^}>{^$custom_item["value"]^}</td>
        </tr>
{^/foreach^}
      </tbody>
    </table>
{^/if^}
  </div>
</div>
<a href="./?menu=statistics&act=daily_report" data-ajax="false" class="ui-shadow ui-btn ui-corner-all ui-btn-a">返回</a>
{^include file=$comfooter_file^}
