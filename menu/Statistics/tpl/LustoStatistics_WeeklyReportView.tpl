{^include file=$comheader_file^}
<script type="text/javascript" src="js/echarts.min.js"></script>
<div class="ui-corner-all custom-corners">
  <div class="ui-bar ui-bar-a ta_c">
    <h1>周度账目</h1>
  </div>
  <div class="ui-body ui-body-a">
    <fieldset class="ui-grid-b">
      <div class="ui-block-a" style="width:15%!important;"><a href="./?menu={^$current_menu^}&act={^$current_act^}&date={^$prev_param^}" class="ui-shadow ui-btn ui-corner-all ui-icon-carat-l ui-btn-icon-left" data-ajax="false">前一区间</a></div>
      <div class="ui-block-b" style="width:70%!important;"><a href="#" class="ui-shadow ui-btn ui-corner-all ui-btn-b">{^$current_param_context^}</a></div>
      <div class="ui-block-c" style="width:15%!important;"><a href="./?menu={^$current_menu^}&act={^$current_act^}&date={^$next_param^}" class="ui-shadow ui-btn ui-corner-all ui-icon-carat-r ui-btn-icon-right" data-ajax="false">后一区间</a></div>
    </fieldset>
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
          <td>{^$date_item^}</td>
          <td>{^$amount_list[$date_key]^}元</td>
          <td>{^$times_list[$date_key]^}次</td>
          <td>{^if $predict_list[$date_key] eq "0.00"^}0{^else^}{^$predict_list[$date_key]^}{^/if^}元</td>
        </tr>
{^/foreach^}
      <tbody>
    </table>
  </div>
</div>
<div id="main" style="width:1000px;height:400px;"></div>
<script type="text/javascript">
    // 基于准备好的dom，初始化echarts实例
    var myChart = echarts.init(document.getElementById('main'));
    // 指定图表的配置项和数据
    var option = {
        //title: {
        //    text: 'ECharts 入门示例'
        //},
        //tooltip: {},
        //legend: {
        //    data:['销量']
        //},
        xAxis: {
            data: ["衬衫","羊毛衫","雪纺衫","裤子","高跟鞋","袜子"]
        },
        yAxis: {},
        series: [{
            name: '销量',
            type: 'bar',
            data: [5, 20, 36, 10, 10, 20]
        }]
    };
    // 使用刚指定的配置项和数据显示图表。
    myChart.setOption(option);
</script>
{^include file=$comfooter_file^}
