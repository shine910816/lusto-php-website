{^include file=$comheader_file^}
<div class="ui-corner-all custom-corners easy_box">
  <div class="ui-bar ui-bar-a ta_c">
    <h1>修改密码</h1>
  </div>
  <div class="ui-body ui-body-a">
    <form action="./" method="post" data-ajax="false">
      <input type="hidden" name="menu" value="{^$current_menu^}" />
      <input type="hidden" name="act" value="{^$current_act^}" />
      <p>&nbsp;</p>
      <label for="login_password">旧密码</label>
      <input type="password" name="login_password" id="login_password" />
{^if isset($user_err_list["old_password"])^}
      <p class="fc_red">{^$user_err_list["old_password"]^}</p>
{^/if^}
      <label for="new_password">新密码</label>
      <input type="password" name="new_password" id="new_password" />
      <label for="new_password_2">确认新密码</label>
      <input type="password" name="new_password_2" id="new_password_2" />
{^if isset($user_err_list["new_password"])^}
      <p class="fc_red">{^$user_err_list["new_password"]^}</p>
{^/if^}
      <p>&nbsp;</p>
      <button type="submit" name="do_change" value="1" class="ui-shadow ui-btn ui-corner-all">确定</button>
    </form>
  </div>
</div>
{^include file=$comfooter_file^}
