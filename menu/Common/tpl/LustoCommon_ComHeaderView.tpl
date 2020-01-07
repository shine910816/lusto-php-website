<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="keywords" content="{^$system_page_keyword^}" />
<meta name="description" content="{^$system_page_description^}" />
<link type="text/css" rel="stylesheet" href="css/jquery.mobile-1.4.5.min.css" />
<link type="text/css" rel="stylesheet" href="css/styleplus.css" />
<script type="text/javascript" src="js/jquery-2.0.0.min.js"></script>
<script type="text/javascript" src="js/jquery.mobile-1.4.5.min.js"></script>
</head>
<body>
<div data-role="page">
<div data-role="panel" id="leftpanel" data-display="reveal">
  <ul data-role="listview" data-shadow="false">
    <li><a href="./" class="ui-btn ui-btn-icon-right ui-icon-home" data-ajax="false">首页</a></li>
{^if $user_login_flg^}
    <li><a href="./?menu=user&act=disp" class="ui-btn ui-btn-icon-right ui-icon-user" data-ajax="false">个人设定 {^$display_custom_nick^}</a></li>
{^else^}
    <li><a href="./?menu=user&act=login" class="ui-btn ui-btn-icon-right ui-icon-user" data-ajax="false">登陆</a></li>
{^/if^}
  </ul>
</div>
{^if $subpanel_file neq ""^}
{^include file=$subpanel_file^}
{^/if^}
<div data-role="header" data-tap-toggle="false" data-position="fixed">
  <h1><a href="#leftpanel" class="ui-nodisc-icon ui-alt-icon ui-btn-left ui-btn ui-icon-bars ui-btn-icon-notext ui-corner-all">{^$page_title^}</a></h1>
</div>
<div data-role="content" class="main_panel">
{^if $navigation_flg^}
<p class="nav_bar">
  <a href="./" data-ajax="false">首页</a>
{^foreach from=$disp_nav_list item=disp_nav_item^}
{^if $disp_nav_item^}
  &gt; {^$disp_nav_item^}
{^/if^}
{^/foreach^}
</p>
{^/if^}