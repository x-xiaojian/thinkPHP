<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo C('WEB_SITE_TITLE');?>|Gms管理平台</title>
<link rel="stylesheet" type="text/css" href="/zhaopin/Public/static/easyui/themes/gms/easyui.css">
<link rel="stylesheet" type="text/css" href="/zhaopin/Public/Admin/css/main.css">
<link rel="stylesheet" type="text/css" href="/zhaopin/Public/static/iconfont/iconfont.css">
<link rel="stylesheet" href="/zhaopin/Public/static/kindeditor/themes/default/default.css" />
<link rel="stylesheet" href="/zhaopin/Public/static/kindeditor/themes/simple/simple.css" />
<script type="text/javascript" src="/zhaopin/Public/static/jquery.min.js"></script>
<script type="text/javascript" src="/zhaopin/Public/static/easyui/jquery.easyui.min.js"></script>
<script type="text/javascript" src="/zhaopin/Public/static/easyui/easyui-lang-zh_CN.js"></script>
<script charset="utf-8" src="/zhaopin/Public/static/kindeditor/kindeditor-min.js"></script>
<script charset="utf-8" src="/zhaopin/Public/static/kindeditor/lang/zh_CN.js"></script>
<script type="text/javascript" src="/zhaopin/Public/Admin/js/main.js"></script>
<script>
/*
var ke_pasteType=2;
var ke_fileManagerJson="<?php echo U('Share/Editor/filemanager');?>";
var ke_uploadJson="<?php echo U('Share/Editor/upload');?>";
var ke_Uid='<?php echo session("Uid");;?>';
*/
var Root='/zhaopin';
</script>
</head>
<body id="layout_main" class="easyui-layout">
<div id="layout_north" data-options="region:'north',border:false">
  <div class="top_left"><a href="<?php echo U('index');?>" class="logo"><img src="/zhaopin/Public/Admin/images/logo.png"></a></div>
  <ul class="top_nav">
      <?php if(is_array($MainMenu)): $i = 0; $__LIST__ = $MainMenu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;?><li><a onClick="MainMenuClick(<?php echo ($key); ?>);" id='t_nav_<?php echo ($key); ?>'><span class="<?php if(empty($$menu['iconCls'])): echo ($menu['iconCls']); else: ?>iconfont icon-form<?php endif; ?>"></span><h2><?php echo ($menu["text"]); ?></h2></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
  </ul>
  <div class="top_right">
    <ul>
      <li><span class="iconfont icon-help" style="font-size:12px;"></span><a href="#">帮助</a></li>
      <!--li><span class="iconfont icon-edit" style="font-size:12px;"></span><a href="<?php echo U('User/updatePassword');?>" class="topbar_menu">修改密码</a></li>
      <li><span class="iconfont icon-set" style="font-size:12px;"></span><a href="<?php echo U('User/updateNickname');?>" class="topbar_menu">修改昵称</a></li-->
      <li><span class="iconfont icon-more" style="font-size:12px;"></span><a href="<?php echo U('Admin/Public/logout');?>" class="topbar_menu">退出</a></li>
    </ul>
    <div class="top_user"> <span><font class="iconfont icon-account" style="color:#fff; padding-right:5px;"></font>admin</span> <i>消息</i> <b>5</b> </div>
  </div>
</div>
<div id="layout_west" data-options="region:'west',split:true,title:'菜单'">
  <ul id="LeftMenu" class="easyui-tree" data-options="url:'<?php echo U('menu');?>',id:'id',text:'name',animate:true,lines:true,onClick:function(node){LeftMenuClick(node);}">
  </ul>
</div>
<div id="layout_center" data-options="region:'center',split:true">
  <div id="MainTabs" class="easyui-tabs" data-options="fit:true,border:false">
    <div title="控制台" data-options="closable:false,id:-1,iconCls:'iconfont icon-all',bodyCls:'tabs_box'" style="padding:5px;"></div>
  </div>
</div>
</body>
</html>