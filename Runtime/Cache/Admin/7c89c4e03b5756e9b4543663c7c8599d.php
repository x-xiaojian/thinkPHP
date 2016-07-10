<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width">
<title><?php echo C('WEB_SITE_TITLE');?>|Gms管理平台</title>
<link rel="stylesheet" type="text/css" href="/zhaopin/Public/Admin/css/login.css">
</head>
<body>
<div class="login">
  <form method="POST" action="<?php echo U('login');?>">
    <div class="logo"></div>
    <div class="login_form">
      <div class="user">
        <input class="text_value" value="" name="username" type="text" id="username">
        <input class="text_value" value="" name="password" type="password" id="password">
      </div>
      <button class="button" id="submit" type="submit">登录</button>
    </div>
    <div id="tip"></div>
    <div class="foot">Copyright &copy; 2015 - 2020.游鱼工作室版权所有</div>
  </form>
</div>
</body>
</html>