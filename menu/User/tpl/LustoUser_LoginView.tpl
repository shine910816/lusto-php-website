{^include file=$comheader_file^}
<div class="ui-corner-all custom-corners easy_box">
  <div class="ui-bar ui-bar-a ta_c">
    <h1>路世通管理员登录</h1>
  </div>
  <div class="ui-body ui-body-a">
    <form action="./" method="post" data-ajax="false">
      <input type="hidden" name="menu" value="{^$current_menu^}" />
      <input type="hidden" name="act" value="{^$current_act^}" />
{^if isset($user_err_list["no_login"])^}
      <p class="fc_red">{^$user_err_list["no_login"]^}</p>
{^else^}
      <p>&nbsp;</p>
{^/if^}
      <label for="login_name">用户名</label>
      <input type="text" name="login_name" id="login_name" value="{^$admin_name^}" />
{^if isset($user_err_list["login_name"])^}
      <p class="fc_red">{^$user_err_list["login_name"]^}</p>
{^/if^}
      <label for="login_password">密码</label>
      <input type="password" name="login_password" id="login_password" />
{^if isset($user_err_list["login_password"])^}
      <p class="fc_red">{^$user_err_list["login_password"]^}</p>
{^/if^}
      <p>&nbsp;</p>
      <button type="submit" name="do_login" value="1" class="ui-shadow ui-btn ui-corner-all">登录</button>
    </form>
  </div>
</div>
{^include file=$comfooter_file^}
