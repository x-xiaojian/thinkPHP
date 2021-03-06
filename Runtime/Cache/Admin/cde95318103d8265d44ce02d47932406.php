<?php if (!defined('THINK_PATH')) exit();?><div id="Config_Bar" class="Bar_tools"><?php echo ($operate); ?></div>

<div style="display: none">
  <form id="Config_Search_From" class="search_from">
	<table>
    <tr>
			<th>配置名称 : </th>
			<td><input name="s_name" type="text" class="easyui-textbox"></td>
		</tr><tr>
			<th>配置类型 : </th>
			<td><input name="s_type" type="text" class="easyui-textbox"></td>
		</tr><tr>
			<th>配置标题 : </th>
			<td><input name="s_title" type="text" class="easyui-textbox"></td>
		</tr><tr>
			<th>配置分组 : </th>
			<td><input name="s_group" type="text" class="easyui-textbox"></td>
		</tr><tr>
			<th>配置参数 : </th>
			<td><input name="s_extra" type="text" class="easyui-textbox"></td>
		</tr><tr>
			<th>说明 : </th>
			<td><input name="s_remark" type="text" class="easyui-textbox"></td>
		</tr><tr>
			<th>状态 : </th>
			<td><select name="s_status" class="easyui-combobox" data-options="value:'',multiple:false,required:false,editable:false"><option value="1" >启用</option><option value="0" >禁用</option></select></td>
		</tr><tr>
			<th>配置值 : </th>
			<td><input name="s_value" type="text" class="easyui-textbox"></td>
		</tr><tr>
			<th>排序 : </th>
			<td><input name="s_sort" type="text" class="easyui-numberbox" style="height:30px;" data-options="min:'0',max:'999',required:false"></td>
		</tr>    </table>
  </form>
</div>

<table id="Config_Data_List"></table>

<script type="text/javascript">
$(function() {
	$("#Config_Data_List").datagrid({
		url : "<?php echo U('Config/index');?>",
		fit : true,
		striped : true,
		border : false,
		pagination : true,
		pageSize : 20,
		pageList : [ 10, 20, 50 ],
		pageNumber : 1,
		sortName : 'id',
		sortOrder : 'desc',
		toolbar : '#Config_Bar',
		singleSelect : true,
		columns : [[
            {field : 'id',title : 'ID',width : 40,sortable:true},
            {field : 'name',title : '配置名称',width : 100,sortable:true},
            {field : 'type',title : '配置类型',width : 100,sortable:true},
            {field : 'title',title : '配置标题',width : 100,sortable:true},
            {field : 'group',title : '配置分组',width : 100,sortable:true},
            {field : 'extra',title : '配置参数',width : 100,sortable:true},
            {field : 'remark',title : '说明',width : 100,sortable:true},
            {field : 'status',title : '状态',width : 100,sortable:true},
            {field : 'value',title : '配置值',width : 100,sortable:true},
            {field : 'sort',title : '排序',width : 100,sortable:true},
			{field : 'operate',title : '操作',width : 200}
		]]
	});
})
</script>