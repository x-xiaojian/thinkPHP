<?php if (!defined('THINK_PATH')) exit();?><div id="AuthRule_Bar" class="Bar_tools"><?php echo ($operate); ?></div>
<table id="AuthRule_Data_List"></table>
<style>
#AuthRule_Data_List .tree-file{ display:none}
</style>
<script type="text/javascript">
$(function() {
	$("#AuthRule_Data_List").treegrid({
		url : "<?php echo U('AuthRule/index');?>",
		fit : true,
		striped : true,
		border : false,
		idField:'id',
		treeField:'title',
		pagination : false,
		toolbar : '#AuthRule_Bar',
		singleSelect : true,
		columns : [[
            {field : 'id',title : 'ID',width : 40},
            {field : 'title',title : '菜单标题',width : 200},
            {field : 'name',title : '菜单名称',width : 200},
            {field : 'type',title : '菜单类别',width : 50},
            {field : 'is_hide',title : '隐藏',width : 50},
            {field : 'status',title : '状态',width : 50},
            {field : 'sort',title : '排序',width : 50},
			{field : 'operate',title : '操作',width : 200}
		]],
	});
})
</script>