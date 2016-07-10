<?php if (!defined('THINK_PATH')) exit();?><div id="AuthRule_Bar" class="Bar_tools"><?php echo ($operate); ?></div>
<form id="AuthRule_Submit_From" class="update_from easyui-tabs" action="<?php echo U('edit');?>" data-options="fit:true,border:false,tools:'#AuthRule_Bar',toolPosition:'left'">
  <div title="基础" data-options="closable:false">
    <table>
      <tr>
        <th>上级菜单 : <span></span></th>
      </tr>
      <tr>
        <td><select name="pid" class="easyui-combotree" data-options="value:'<?php echo ($_info["pid"]); ?>',url:'<?php echo U('Admin/Public/api',array('url'=> 'Admin/AuthRule/get_auth_rule'));?>',multiple:false,required:false,editable:false">
          </select></td>
      </tr>
      <tr>
        <th>菜单名称 : <span></span></th>
      </tr>
      <tr>
        <td><input name="name" value="<?php echo ($_info["name"]); ?>" type="text" class="easyui-textbox" data-options="required:false"></td>
      </tr>
      <tr>
        <th>菜单标题 : <span></span></th>
      </tr>
      <tr>
        <td><input name="title" value="<?php echo ($_info["title"]); ?>" type="text" class="easyui-textbox" data-options="required:false"></td>
      </tr>
      <tr>
        <th>图标 : <span>图标采用阿里巴巴矢量图标库[http://www.iconfont.cn/]（文件存储在Public\static\iconfont下，更改前查看iconfont.css文件）</span></th>
      </tr>
      <tr>
        <td><input name="icon" value="<?php echo ($_info["icon"]); ?>" type="text" class="easyui-textbox" data-options="required:false"></td>
      </tr>
      <tr>
        <th>菜单类别 : <span></span></th>
      </tr>
      <tr>
        <td><select name="type" class="easyui-combobox" data-options="value:'<?php echo ($_info["is_menu"]); ?>',multiple:false,required:false,editable:false">
            <option value="1" >页面菜单</option>
            <option value="2" >记录菜单</option>
            <option value="0" >其他</option>
          </select></td>
      </tr>
      <tr>
        <th>隐藏 : <span></span></th>
      </tr>
      <tr>
        <td><select name="is_hide" class="easyui-combobox" data-options="value:'<?php echo ($_info["is_hide"]); ?>',multiple:false,required:false,editable:false">
            <option value="1" >是</option>
            <option value="0" >否</option>
          </select></td>
      </tr>
      <tr>
        <th>状态 : <span></span></th>
      </tr>
      <tr>
        <td><select name="status" class="easyui-combobox" data-options="value:'<?php echo ($_info["status"]); ?>',multiple:false,required:false,editable:false">
            <option value="1" >启用</option>
            <option value="0" >禁用</option>
          </select></td>
      </tr>
      <tr>
        <th>排序 : <span></span></th>
      </tr>
      <tr>
        <td><input name="sort" value="<?php echo ($_info["sort"]); ?>" type="text" class="easyui-numberbox" style="height:30px;" data-options="min:'0',max:'99',precision:'0',decimalSeparator:'.',groupSeparator:',',required:false"></td>
      </tr>
      <tr>
        <th>附加参数 : <span></span></th>
      </tr>
      <tr>
        <td><input name="condition" value="<?php echo ($_info["condition"]); ?>" type="text" class="easyui-textbox" data-options="required:false,multiline:true" style="width:200px; height:50px;"></td>
      </tr>
      <tr>
        <th style="text-align:center;"><a class="easyui-linkbutton" href="JavaScript:void(0);" onclick="From_Submit('AuthRule')" data-options="iconCls:'iconfont icon-edit'"><span style="font-size:14px; font-weight:600;">更改</span></a></th>
      </tr>
    </table>
  </div>
  <input name="id" type="hidden" value="<?php echo I('get.id');?>" />
</form>