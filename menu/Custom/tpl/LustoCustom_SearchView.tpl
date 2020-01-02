{^include file=$comheader_file^}
<script type="text/javascript">
$(document).ready(function(){
    $("#search_keyword").select();
});
</script>
<div class="ui-corner-all custom-corners">
  <div class="ui-bar ui-bar-a ta_c">
    <h1>注册会员</h1>
  </div>
  <div class="ui-body ui-body-a">
    <fieldset class="ui-grid-b">
      <div class="ui-block-a"><a href="#" class="ui-shadow ui-btn ui-corner-all ui-btn-b" data-ajax="false">新用户</a></div>
      <div class="ui-block-b"><a href="#" class="ui-shadow ui-btn ui-corner-all ui-btn-a" data-ajax="false">旧卡用户</a></div>
      <div class="ui-block-c"><a href="#" class="ui-shadow ui-btn ui-corner-all ui-btn-a" data-ajax="false">批量旧卡用户</a></div>
    </fieldset>
  </div>
</div>
<h1></h1>
<div class="ui-corner-all custom-corners">
  <div class="ui-bar ui-bar-a ta_c">
    <h1>查询会员</h1>
  </div>
  <div class="ui-body ui-body-a">
    <form action="./" method="post" data-ajax="false">
      <input type="hidden" name="menu" value="{^$current_menu^}" />
      <input type="hidden" name="act" value="{^$current_act^}" />
      <fieldset class="ui-grid-a">
        <div class="ui-block-a" style="width:25%!important;">
          <fieldset data-role="controlgroup" data-type="horizontal" data-mini="true">
            <input type="radio" name="search_type" value="1" id="search_type_card"{^if $search_type eq "1"^} checked{^/if^} />
            <label for="search_type_card">会员卡号</label>
            <input type="radio" name="search_type" value="2" id="search_type_mobile"{^if $search_type eq "2"^} checked{^/if^} />
            <label for="search_type_mobile">手机号</label>
            <input type="radio" name="search_type" value="3" id="search_type_plate"{^if $search_type eq "3"^} checked{^/if^} />
            <label for="search_type_plate">车牌照号</label>
          </fieldset>
        </div>
        <div class="ui-block-b" style="width:75%!important; padding-right:10px!important;">
          <input type="text" name="search_keyword" value="{^$search_keyword^}" placeholder="查询关键字" id="search_keyword" style="text-transform:uppercase;" />
        </div>
      </fieldset>
      <button type="submit" name="do_search" value="1" class="ui-shadow ui-btn ui-corner-all ui-btn-a">查询</button>
    </form>
{^if $search_flg^}
{^if !empty($search_result)^}
    <table data-role="table" data-mode="columntoggle:none" class="ui-responsive disp_table">
      <thead>
        <tr>
          <th class="first_th">会员卡号</th>
          <th>姓名</th>
          <th>手机号码</th>
          <th>车牌照号</th>
          <th>车型</th>
        </tr>
      </thead>
      <tbody>
{^foreach from=$search_result key=custom_id item=custom_item^}
        <tr>
          <td>{^if $custom_item["card_id"]^}{^$custom_item["card_id"]^}{^else^}未绑定{^/if^}</td>
          <td>{^$custom_item["custom_name"]^}</td>
          <td>{^$custom_item["custom_mobile"]^}</td>
          <td>{^$region_list[$custom_item["custom_plate_region"]]^}{^$custom_item["custom_plate"]^}</td>
          <td>{^$vehicle_list[$custom_item["custom_vehicle_type"]]^}</td>
        </tr>
{^/foreach^}
      </tbody>
    </table>
{^else^}
    <p>未查询到符合信息的用户</p>
{^/if^}
  </div>
{^/if^}
</div>
<a href="./" data-ajax="false" class="ui-shadow ui-btn ui-corner-all ui-btn-a">返回</a>
{^include file=$comfooter_file^}
