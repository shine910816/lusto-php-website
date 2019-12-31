{^include file=$comheader_file^}
<div class="ui-corner-all custom-corners">
  <div class="ui-bar ui-bar-a ta_c">
    <h1>成员管理</h1>
  </div>
  <div class="ui-body ui-body-a">
{^if !empty($admin_list)^}
    <table data-role="table" data-mode="columntoggle:none" class="ui-responsive disp_table">
      <thead>
        <tr>
          <th style="width:100px;" class="first_th">状态</th>
          <th style="width:150px;">用户名</th>
          <th style="width:250px;">备注</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
{^foreach from=$admin_list key=admin_id item=admin_item^}
        <tr>
          <td><p>{^if $admin_item["admin_activity"]^}<span style="color:#00F600;">●</span> 开启{^else^}<span style="color:#F60000;">●</span> 关闭{^/if^}</p></td>
          <td><p>{^$admin_item["admin_name"]^}</p></td>
          <td class="ta_l"><p>{^$admin_item["admin_note"]^}</p></td>
          <td>
            <a href="./?menu=admin&act=admin_create&admin_id={^$admin_id^}" class="ui-shadow ui-btn ui-corner-all ui-btn-inline ui-icon-edit ui-btn-icon-left" data-ajax="false">编辑</a>
            <a href="./?menu=admin&act=admin_list&do_reset={^$admin_id^}" class="ui-shadow ui-btn ui-corner-all ui-btn-inline ui-icon-refresh ui-btn-icon-left" data-ajax="false">重置</a>
{^if $admin_item["admin_activity"]^}
            <a href="./?menu=admin&act=admin_list&do_activity={^$admin_id^}" class="ui-shadow ui-btn ui-corner-all ui-btn-inline ui-icon-delete ui-btn-icon-left" data-ajax="false">关闭</a>
{^else^}
            <a href="./?menu=admin&act=admin_list&do_activity={^$admin_id^}" class="ui-shadow ui-btn ui-corner-all ui-btn-inline ui-icon-check ui-btn-icon-left" data-ajax="false">开启</a>
{^/if^}
          </td>
        </tr>
{^/foreach^}
      </tbody>
    </table>
{^else^}
    <p>还没有已创建的用户</p>
{^/if^}
    <a class="ui-shadow ui-btn ui-corner-all" href="./?menu=admin&act=admin_create" data-ajax="false">创建用户</a>
  </div>
</div>
<a href="./" data-ajax="false" class="ui-shadow ui-btn ui-corner-all ui-btn-a">返回</a>
{^include file=$comfooter_file^}
