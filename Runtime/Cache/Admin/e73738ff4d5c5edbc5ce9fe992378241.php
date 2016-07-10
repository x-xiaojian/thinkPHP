<?php if (!defined('THINK_PATH')) exit();?><div id="User_Bar" class="Bar_tools"><?php echo ($operate); ?></div>
<form id="User_Submit_From" class="update_from easyui-tabs" action="<?php echo U('add');?>" data-options="fit:true,border:false,tools:'#User_Bar',toolPosition:'left'">
  <div title="基础" data-options="closable:false">
    <table>
      <tr>
        <th>用户名 : <span></span></th>
      </tr>
      <tr>
        <td><input name="username" value="" type="text" class="easyui-textbox" data-options="required:false"></td>
      </tr>
      <tr>
        <th>真实姓名 : <span></span></th>
      </tr>
      <tr>
        <td><input name="nickname" value="" type="text" class="easyui-textbox" data-options="required:false"></td>
      </tr>
      <tr>
        <th>用户密码 : <span></span></th>
      </tr>
      <tr>
        <td><input name="password" value="" type="text" class="easyui-textbox" data-options="required:false"></td>
      </tr>
      <tr>
        <th>注册类型 : <span></span></th>
      </tr>
      <tr>
        <td><input name="group_id" type="text" class="easyui-combotree" data-options="url:'<?php echo U('Admin/Public/api',array('url'=>'Admin/AuthGroup/get_auth_group','var'=>'1'));?>',valueField:'id',textField:'text',multiple:false,required:false,editable:false"></td>
      </tr>
      <tr>
        <th>备注 : <span></span></th>
      </tr>
      <tr>
        <td><input name="remark" value="" type="text" class="easyui-textbox" data-options="required:false,multiline:true" style="width:300px; height:70px;"></td>
      </tr>
      <tr>
        <th style="text-align:center;"><a class="easyui-linkbutton" href="JavaScript:void(0);" onclick="From_Submit('User')" data-options="iconCls:'iconfont icon-add'"><span style="font-size:14px; font-weight:600;">新增</span></a></th>
      </tr>
    </table>
  </div>
  <div title="其他" data-options="closable:false">
    <table>
      <tr>
        <th>注册日期 : <span></span></th>
      </tr>
      <tr>
        <td><input name="create_time" value="" type="text" class="easyui-datetimebox" data-options="required:false"></td>
      </tr>
      <tr>
        <th>最后修改时间 : <span></span></th>
      </tr>
      <tr>
        <td><input name="update_time" value="" type="text" class="easyui-datetimebox" data-options="required:false"></td>
      </tr>
      <tr>
        <th>上次登录IP : <span></span></th>
      </tr>
      <tr>
        <td><input name="logip" value="" type="text" class="easyui-textbox" data-options="required:false"></td>
      </tr>
      <tr>
        <th>上次登录时间 : <span></span></th>
      </tr>
      <tr>
        <td><input name="logdatetime" value="" type="text" class="easyui-datetimebox" data-options="required:false"></td>
      </tr>
      <tr>
        <th>验证/状态 : <span></span></th>
      </tr>
      <tr>
        <td><select name="status" class="easyui-combobox" data-options="value:'1',multiple:false,required:false,editable:false">
            <option value="1" >已验证</option>
            <option value="0" >未验证</option>
          </select></td>
      </tr>
      <tr>
        <th style="text-align:center;"><a class="easyui-linkbutton" href="JavaScript:void(0);" onclick="From_Submit('User')" data-options="iconCls:'iconfont icon-add'"><span style="font-size:14px; font-weight:600;">新增</span></a></th>
      </tr>
    </table>
  </div>
</form>