{^include file=$comheader_file^}
<script type="text/javascript">
{^foreach from=$chart_info key=chart_key item=chart_item^}
var {^$chart_key^}_data = {^$chart_item^};
{^/foreach^}
</script>
<script type="text/javascript" src="js/echarts.min.js"></script>
<div class="ui-corner-all custom-corners">
  <div class="ui-bar ui-bar-a ta_c">
    <h1>年度账目</h1>
  </div>
  <div class="ui-body ui-body-a">
    <fieldset class="ui-grid-b">
      <div class="ui-block-a" style="width:15%!important;"><a href="./?menu={^$current_menu^}&act={^$current_act^}&date={^$prev_param^}{^if $week_interval_flg^}&week=1{^/if^}" class="ui-shadow ui-btn ui-corner-all ui-icon-carat-l ui-btn-icon-left" data-ajax="false">上一年</a></div>
      <div class="ui-block-b" style="width:70%!important;"><a href="#" class="ui-shadow ui-btn ui-corner-all ui-btn-b">{^$current_param_context^}</a></div>
      <div class="ui-block-c" style="width:15%!important;"><a href="./?menu={^$current_menu^}&act={^$current_act^}&date={^$next_param^}{^if $week_interval_flg^}&week=1{^/if^}" class="ui-shadow ui-btn ui-corner-all ui-icon-carat-r ui-btn-icon-right" data-ajax="false">下一年</a></div>
    </fieldset>
    <fieldset class="ui-grid-a">
      <div class="ui-block-a"><a href="./?menu={^$current_menu^}&act={^$current_act^}&date={^$current_param^}" class="ui-shadow ui-btn ui-corner-all ui-btn-{^if $week_interval_flg^}a{^else^}b{^/if^}" data-ajax="false">年度月间</a></div>
      <div class="ui-block-b"><a href="./?menu={^$current_menu^}&act={^$current_act^}&date={^$current_param^}&week=1" class="ui-shadow ui-btn ui-corner-all ui-btn-{^if $week_interval_flg^}b{^else^}a{^/if^}" data-ajax="false">年度周间</a></div>
    </fieldset>
    <div id="amount_chart" class="chart_box"></div>
    <div id="times_chart" class="chart_box"></div>
    <div id="predict_chart" class="chart_box"></div>
    <script type="text/javascript" src="js/statistics/chart.js"></script>
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
        <tr>
          <td>{^$date_item|replace:" ":"<br/>"^}</td>
          <td>{^$amount_list[$date_key]^}元</td>
          <td>{^$times_list[$date_key]^}次</td>
          <td>{^if $predict_list[$date_key] eq "0.00"^}0{^else^}{^$predict_list[$date_key]^}{^/if^}元</td>
        </tr>
{^/foreach^}
      <tbody>
    </table>
  </div>
</div>
{^include file=$comfooter_file^}
