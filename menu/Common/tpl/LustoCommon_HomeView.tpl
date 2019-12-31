{^include file=$comheader_file^}
<div class="ui-body ui-body-a easy_box">
  <a class="ui-shadow ui-btn ui-corner-all" href="./" data-ajax="false">其他按钮</a>
{^if $user_admin_flg^}
  <a class="ui-shadow ui-btn ui-corner-all" href="./?menu=admin&act=admin_list" data-ajax="false">成员管理</a>
  <a class="ui-shadow ui-btn ui-corner-all" href="./" data-ajax="false">账目管理</a>
{^/if^}
</div>

{^include file=$comfooter_file^}
