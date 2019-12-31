{^include file=$comheader_file^}
<div class="ui-corner-all custom-corners easy_box">
  <div class="ui-bar ui-bar-a ta_c">
    <h1>{^$display_custom_nick^}</h1>
  </div>
  <div class="ui-body ui-body-a">
    <a class="ui-shadow ui-btn ui-corner-all" href="./?menu=user&act=change_password" data-ajax="false">修改密码</a>
    <a class="ui-shadow ui-btn ui-corner-all" href="./?menu=user&act=login&do_logout=1" data-ajax="false">登出用户</a>
  </div>
</div>
{^include file=$comfooter_file^}
