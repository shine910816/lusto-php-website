{^include file=$comheader_file^}
<div class="ui-corner-all custom-corners">
  <div class="ui-bar ui-bar-a ta_c">
    <h1>账目管理</h1>
  </div>
  <div class="ui-body ui-body-a">
    <table data-role="table" data-mode="columntoggle:none" class="ui-responsive disp_table">
      <thead>
        <tr>
          <th style="width:25%!important;">日期</th>
          <th style="width:25%!important;">会员卡销售额</th>
          <th style="width:25%!important;">会员洗车次数</th>
          <th style="width:25%!important;">预估销售额</th>
        </tr>
      </thead>
      <tbody>
{^foreach from=$date_list key=date_key item=date_item^}
        <tr{^if $date_key eq $today_date^} style="font-weight:bold;"{^/if^}>
          <td>{^$date_item^}</td>
          <td>{^$amount_list[$date_key]^}元</td>
          <td>{^$times_list[$date_key]^}次</td>
          <td>{^if $predict_list[$date_key] eq "0.00"^}0{^else^}{^$predict_list[$date_key]^}{^/if^}元</td>
        </tr>
{^/foreach^}
      <tbody>
    </table>
    <fieldset class="ui-grid-b">
      <div class="ui-block-a"><a href="./?menu={^$current_menu^}&act=weekly_report" class="ui-shadow ui-btn ui-corner-all" data-ajax="false">周度账目</a></div>
      <div class="ui-block-b"><a href="./?menu={^$current_menu^}&act=monthly_report" class="ui-shadow ui-btn ui-corner-all" data-ajax="false">月度账目</a></div>
      <div class="ui-block-c"><a href="./?menu={^$current_menu^}&act=yearly_report" class="ui-shadow ui-btn ui-corner-all" data-ajax="false">年度账目</a></div>
    </fieldset>
  </div>
</div>
{^include file=$comfooter_file^}
