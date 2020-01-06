{^include file=$comheader_file^}
<div class="ui-corner-all custom-corners">
  <div class="ui-bar ui-bar-a ta_c">
    <h1>套餐管理</h1>
  </div>
  <div class="ui-body ui-body-a">
    <fieldset class="ui-grid-a">
      <div class="ui-block-a"><a href="./?menu=admin&act=package_list" class="ui-shadow ui-btn ui-corner-all ui-btn-{^if $special_flg^}a{^else^}b{^/if^}" data-ajax="false">普通套餐</a></div>
      <div class="ui-block-b"><a href="./?menu=admin&act=package_list&special=1" class="ui-shadow ui-btn ui-corner-all ui-btn-{^if !$special_flg^}a{^else^}b{^/if^}" data-ajax="false">优惠套餐</a></div>
    </fieldset>
{^if !empty($package_list)^}
    <table data-role="table" data-mode="columntoggle:none" class="ui-responsive disp_table">
      <thead>
        <tr>
          <th class="first_th">编号</th>
          <th>车型</th>
          <th>价格</th>
          <th>次数</th>
        </tr>
      </thead>
      <tbody>
{^foreach from=$package_list key=p_id item=package_item^}
        <tr>
          <td>{^$p_id^}</td>
          <td>{^$vehicle_list[$package_item["p_vehicle_type"]]^}</td>
          <td>{^$package_item["p_price"]^}</td>
          <td>{^if $package_item["p_infinity_flg"]^}不限次数{^else^}{^$package_item["p_times"]^}{^/if^}</td>
        </tr>
{^/foreach^}
      </tbody>
    </table>
{^else^}
    <p>还没有已创建的套餐</p>
{^/if^}
  </div>
  <a href="./" data-ajax="false" class="ui-shadow ui-btn ui-corner-all ui-btn-a">返回</a>
</div>
{^include file=$comfooter_file^}
