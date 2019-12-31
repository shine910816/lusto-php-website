{^include file=$comheader_file^}
<div class="ui-corner-all custom-corners easy_box">
  <div class="ui-bar ui-bar-a ta_c">
    <h1>创建用户</h1>
  </div>
  <div class="ui-body ui-body-a">
    <form action="./" method="post" data-ajax="false">
      <input type="hidden" name="menu" value="{^$current_menu^}" />
      <input type="hidden" name="act" value="{^$current_act^}" />
      <p>&nbsp;</p>
      <label for="admin_name">用户名</label>
{^if $edit_mode^}
      <input type="text" id="admin_name" value="{^$admin_name^}" disabled />
      <input type="hidden" name="admin_id" value="{^$admin_id^}" />
{^else^}
      <input type="text" name="admin_name" id="admin_name" value="{^$admin_name^}" />
{^if isset($user_err_list["admin_name"])^}
      <p class="fc_red">{^$user_err_list["admin_name"]^}</p>
{^/if^}
{^/if^}
      <label for="admin_note">备注</label>
      <input type="text" name="admin_note" id="admin_note" value="{^$admin_note^}" />
      <p>&nbsp;</p>
      <button type="submit" name="do_submit" value="1" class="ui-shadow ui-btn ui-corner-all ui-btn-b">{^if $edit_mode^}确认{^else^}创建{^/if^}</button>
      <a href="./?menu=admin&act=admin_list" data-ajax="false" class="ui-shadow ui-btn ui-corner-all ui-btn-a">返回</a>
    </form>
  </div>
</div>
{^include file=$comfooter_file^}
