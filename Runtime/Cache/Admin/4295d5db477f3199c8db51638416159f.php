<?php if (!defined('THINK_PATH')) exit();?><div id="User_Bar" class="Bar_tools"><?php echo ($operate); ?></div>
<div id="User_Dbox" style="display: none">
  <form id="User_Search_From" class="search_from">
    <table>
      <tr>
        <th>用户名 : </th>
        <td><input name="s_username" type="text" class="easyui-textbox"></td>
      </tr>
      <tr>
        <th>真实姓名 : </th>
        <td><input name="s_nickname" type="text" class="easyui-textbox"></td>
      </tr>
      <tr>
        <th>用户密码 : </th>
        <td><input name="s_password" type="text" class="easyui-textbox"></td>
      </tr>
      <tr>
        <th>注册类型 : </th>
        <td><input name="s_group_id" type="text" class="easyui-combotree" data-options="url:'<?php echo U('Admin/Public/api',array('url'=>'Admin/AuthGroup/get_auth_group','var'=>'1'));?>',valueField:'id',textField:'text',multiple:false,required:false,editable:false"></td>
      </tr>
      <tr>
        <th>注册日期 : </th>
        <td><input name="s_create_time_min" type="text" class="easyui-datetimebox">
          -
          <input name="s_create_time_max" type="text" class="easyui-datetimebox"></td>
      </tr>
      <tr>
        <th>最后修改时间 : </th>
        <td><input name="s_update_time_min" type="text" class="easyui-datetimebox">
          -
          <input name="s_update_time_max" type="text" class="easyui-datetimebox"></td>
      </tr>
      <tr>
        <th>备注 : </th>
        <td><input name="s_remark" type="text" class="easyui-textbox"></td>
      </tr>
      <tr>
        <th>验证/状态 : </th>
        <td><select name="s_status" class="easyui-combobox" data-options="value:'',multiple:false,required:false,editable:false">
            <option value="1" >已验证</option>
            <option value="0" >未验证</option>
          </select></td>
      </tr>
    </table>
  </form>
</div>
<table id="User_Data_List"></table>
<script type="text/javascript">
$(function() {
	$("#User_Data_List").datagrid({
		url : "<?php echo U('User/index');?>",
		fit : true,
		striped : true,
		border : false,
		pagination : true,
		pageSize : 20,
		pageList : [ 10, 20, 50 ],
		pageNumber : 1,
		sortName : 'id',
		sortOrder : 'desc',
		toolbar : '#User_Bar',
		singleSelect : true,
		columns : [[
            {field : 'id',title : 'ID',width : 60,sortable:true},
            {field : 'username',title : '用户名',width : 100,sortable:true},
            {field : 'nickname',title : '真实姓名',width : 100,sortable:true},
            {field : 'group_id',title : '注册类型',width : 60,sortable:true},
            {field : 'status',title : '验证/状态',width : 100,sortable:true},
            {field : 'create_time',title : '注册时间',width : 100,sortable:true},
            {field : 'update_time',title : '修改时间',width : 100,sortable:true},
			{field : 'operate',title : '操作',width : 140}
		]]
	});
})
</script>