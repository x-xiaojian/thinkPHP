<?php if (!defined('THINK_PATH')) exit();?><div id="DatabaseExport_Bar" class="Bar_tools"><?php echo ($operate); ?></div>
<table id="DatabaseExport_Data_List"></table>

<script type="text/javascript">
$(function() {
	$("#DatabaseExport_Data_List").datagrid({
		url : "<?php echo U('Database/export_list');?>",
		fit : true,
		striped : true,
		border : false,
		pagination : false,
		singleSelect : false,
		sortName : 'name',
		sortOrder : 'desc',
		toolbar : '#DatabaseExport_Bar',
		columns : [[
            {field : 'id',title : '表名',width : 30,checkbox:'true'},
            {field : 'name',title : '表名',width : 200,sortable:true},
            {field : 'rows',title : '数据量',width : 120,sortable:true},
            {field : 'data_length',title : '数据大小',width : 120,sortable:true},
            {field : 'create_time',title : '创建时间',width : 160,sortable:true},
			{field : 'operate',title : '操作',width : 150}
		]],
	});
})
function Ajax_DatabaseExport(Datagrid) {
	var rows = $('#'+Datagrid).datagrid('getSelections');
	if (rows.length == 0) {
		$.messager.show({title:'错误提示',msg:'至少选择一行记录！',timeout:2000,showType:'slide'});
	}else{
		var ids = [];
		for (var i = 0; i < rows.length; i++) {
			ids.push(rows[i].id);
		}
		idsinfo=ids.join(',');
		$.post("<?php echo U('export');?>",{ids:idsinfo},function(res){
			if(!res.status){
				$.messager.show({title:'错误提示',msg:res.info,timeout:2000,showType:'slide'});
			}else{
				backup(0,0);
			}
		})
		
	}
}
function backup(id,start){
	$.post("<?php echo U('export');?>",{id:id,start:start},function(res){
		if(!res.status){
			$.messager.show({title:'错误提示',msg:res.info,timeout:2000,showType:'slide'});
		}else{
			$.messager.show({title:'成功提示',msg:res.info,timeout:1000,showType:'slide'});
			if(res.id != 'over' ){
				backup(res.id,res.start);
			}
		}

	})
}
</script>