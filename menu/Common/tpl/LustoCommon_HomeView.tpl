{^include file=$comheader_file^}
<style type="text/css">
.high_button {
  height:200px;
  line-height:200px;
  font-size:2.5em;
}
</style>
<div class="ui-grid-b">
  <div class="ui-block-a"><a class="ui-shadow ui-btn ui-corner-all high_button" href="#" data-ajax="false">洗车</a></div>
  <div class="ui-block-b"><a class="ui-shadow ui-btn ui-corner-all high_button" href="#" data-ajax="false">开户</a></div>
  <div class="ui-block-c"><a class="ui-shadow ui-btn ui-corner-all high_button" href="#" data-ajax="false">续费</a></div>
{^if $user_admin_flg^}
  <div class="ui-block-a"><a class="ui-shadow ui-btn ui-corner-all high_button" href="./?menu=admin&act=package_list" data-ajax="false">套餐管理</a></div>
  <div class="ui-block-b"><a class="ui-shadow ui-btn ui-corner-all high_button" href="./?menu=admin&act=admin_list" data-ajax="false">成员管理</a></div>
  <div class="ui-block-c"><a class="ui-shadow ui-btn ui-corner-all high_button" href="#" data-ajax="false">账目管理</a></div>
{^/if^}
</div>
{^include file=$comfooter_file^}
