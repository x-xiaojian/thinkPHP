<?php if (!defined('THINK_PATH')) exit();?><div id="AuthGroup_Bar" class="Bar_tools"><?php echo ($operate); ?></div>
<table id="AuthGroup_Data_List"></table>
<script type="text/javascript">
$(function() {
	$("#AuthGroup_Data_List").treegrid({
		url : "<?php echo U('AuthGroup/index');?>",
		fit : true,
		striped : true,
		border : false,
		idField:'id',
		treeField:'title',
		pagination : false,
		toolbar : '#AuthGroup_Bar',
		singleSelect : true,
		columns : [[
            {field : 'id',title : 'ID',width : 40},
            {field : 'title',title : '名称',width : 120},
            {field : 'status',title : '状态',width : 100},
			{field : 'operate',title : '操作',width : 200}
		]],
	});
})
</script>