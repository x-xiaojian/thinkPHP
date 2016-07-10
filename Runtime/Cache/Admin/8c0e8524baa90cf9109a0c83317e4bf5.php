<?php if (!defined('THINK_PATH')) exit();?><div id="DatabaseImport_Bar" class="Bar_tools"><?php echo ($operate); ?></div>

<table id="DatabaseImport_Data_List"></table>

<script type="text/javascript">
$(function() {
	$("#DatabaseImport_Data_List").datagrid({
		url : "<?php echo U('Database/import_list');?>",
		fit : true,
		striped : true,
		border : false,
		pagination : false,
		sortName : 'name',
		sortOrder : 'desc',
		toolbar : '#DatabaseImport_Bar',
		singleSelect : true,
		columns : [[
            {field : 'id',title : '备份名称',width : 200,sortable:true},
            {field : 'part',title : '卷数',width : 80,sortable:true},
            {field : 'compress',title : '压缩',width : 80,sortable:true},
            {field : 'size',title : '数据大小',width : 80,sortable:true},
            {field : 'time',title : '备份时间',width : 200,sortable:true},
			{field : 'operate',title : '操作',width : 150}
		]],
	});
})
function Ajax_DatabaseImport(url,Datagrid) {
	var self = this, status = ".";
	$.get(url, success, "json");
	function success(data){
		if(data.status){
			if(data.gz){
				data.info += status;
				if(status.length === 5){
					status = ".";
				} else {
					status += ".";
				}
			}
			$.messager.show({title:'成功提示',msg:data.info,timeout:1000,showType:'slide'});
			if(data.part){
				$.get(url,{"part":data.part,"start":data.start},success,"json");
			}
		} else {
			$.messager.show({title:'错误提示',msg:data.info,timeout:2000,showType:'slide'});
		}
	}
}
</script>