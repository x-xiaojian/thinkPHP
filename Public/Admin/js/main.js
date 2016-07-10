
function MainMenuClick(m_id) {
	$('#LeftMenu').tree({
		url:Root+'/index.php?m=Admin&c=Index&a=menu&pid='+m_id
	});
	
	$('.top_nav a').removeClass("selected");
	$('#t_nav_'+m_id).addClass("selected");
}

function LeftMenuClick(node) {
	if($('#LeftMenu').tree('isLeaf',node.target)){//判断是否是叶子节点
		rule=node.attributes.rule;
		var strs= new Array();
		strs=rule.split("/"); //字符分割 
		var cname = strs[1];
		var tit = node.text;
		var url = node.attributes.url;
		var icon = node.iconCls;
		if(icon==null){
			icon='iconfont icon-viewlist'
		}
		if (url) {
			UpdateTabs(cname, url, tit, icon);
		}
	}
}


function UpdateTabs(model_name, url, tit, icon) {
	if ($('#tabs_'+model_name).length>0) {
		index = $('#MainTabs').tabs('getTabIndex',$('#tabs_'+model_name));
		$('#MainTabs').tabs('select',index)
		Selected_tabs=$('#MainTabs').tabs('getSelected')
		options_s={}
		options_s.href=url
		options_s.bodyCls="tabs_box"
		if(tit!=''){
			options_s.title=tit
		}
		if(icon!=''){
			options_s.iconCls=icon
		}
		$('#MainTabs').tabs('update', {
			tab:Selected_tabs,
			options: options_s
		});
		Selected_tabs.panel('refresh');
	} else {
		options_s={}
		options_s.id='tabs_'+model_name
		options_s.title=tit
		options_s.href=url
		options_s.closable=true
		options_s.bodyCls="tabs_box"
		if(icon!=null){
			options_s.iconCls=icon
		}else{
			options_s.iconCls='iconfont icon-viewlist'
		}
		$('#MainTabs').tabs('add', options_s);
	}
}



function Datagrid_Ajax(url,Datagrid){
	$.post(url,{},function(res){
		if(!res.status){
			$.messager.show({title:'错误提示',msg:res.info,timeout:2000,showType:'slide'});
		}else{
			$('#'+Datagrid).datagrid('reload');
			$.messager.show({title:'成功提示',msg:res.info,timeout:1000,showType:'slide'});
		}
	})
}

function Datagrid_Ajax_Checkbox(url,Datagrid) {
	var rows = $('#'+Datagrid).datagrid('getSelections');
	if (rows.length == 0) {
		$.messager.show({title:'错误提示',msg:'至少选择一行记录！',timeout:2000,showType:'slide'});
	}else{
		var id_arr = [];
		for (var i = 0; i < rows.length; i++) {
			id_arr.push(rows[i].id);
		}
		ids=id_arr.join(',');
		$.post(url,{ids:ids},function(res){
			if(!res.status){
				$.messager.show({title:'错误提示',msg:res.info,timeout:2000,showType:'slide'});
			}else{
				$('#'+Datagrid).datagrid('reload');
				$.messager.show({title:'成功提示',msg:res.info,timeout:1000,showType:'slide'});
			}
		})
		
	}
}

//搜索
function Data_Search(Search_From,Datagrid_data){
	$('#'+Search_From).dialog({
		width:600,   
		height:350,  
		title : '搜索',
		modal:true,
		buttons : [{
				text : '搜索',
				iconCls : 'iconfont icon-search',
				handler : function () {
					var queryParams = $('#'+Datagrid_data).datagrid('options').queryParams;
					$.each($('#'+Search_From).serializeArray(), function() {
						queryParams[this['name']] = this['value'];
					});
					$('#'+Datagrid_data).datagrid('reload');
				},
			}],
	})
}

/* 提交表单 */
function From_Submit(Model_name){
	$.post($('#'+Model_name+'_Submit_From').attr("action"), $('#'+Model_name+'_Submit_From').serialize(), function(res){
		if(!res.status){
			$.messager.show({title:'错误提示',msg:res.info,timeout:2000,showType:'slide'});
		}else{
			$.messager.show({title:'成功提示',msg:res.info,timeout:1000,showType:'slide'});
			UpdateTabs(Model_name, res.url+'&cachedata='+new Date().getTime(), '', 'iconfont icon-viewlist');
		}
	})
}

function Data_Remove(Data_from_url,Datagrid_data){
	$.messager.confirm('确定操作', '您正在要删除所选的记录吗？', function (flag) {
		if (flag){
			$.post(Data_from_url,{},function(res){
				if(!res.status){
					$.messager.show({title:'错误提示',msg:res.info,timeout:2000,showType:'slide'});
				}else{
					$('#'+Datagrid_data).datagrid('reload');
					$.messager.show({title:'成功提示',msg:res.info,timeout:1000,showType:'slide'});
				}
			})
		}
	})
}

function Data_Remove2(Data_from_url,Datagrid_data){
	$.messager.confirm('确定操作', '您正在要删除所选的记录吗？', function (flag) {
		if (flag){
			$.post(Data_from_url,{},function(res){
				if(!res.status){
					$.messager.show({title:'错误提示',msg:res.info,timeout:2000,showType:'slide'});
				}else{
					$('#'+Datagrid_data).treegrid('reload');
					$.messager.show({title:'成功提示',msg:res.info,timeout:1000,showType:'slide'});
				}
			})
		}
	})
}
/* 刷新页面 */
function Data_Reload(Data_Box){
	$('#'+Data_Box).datagrid('reload');
}

/* 刷新页面 */
function Data_Reload2(Data_Box){
	$('#'+Data_Box).treegrid('reload');
}

KindEditor.ready(function(K) {});


/* 上传附件 */

function updata_fields(file_box){
	KindEditor.ready(function(K) {
		updata_fields_editor = K.editor({
			allowFileManager : true,
			pasteType:ke_pasteType,
			fileManagerJson: ke_fileManagerJson,
			uploadJson: ke_uploadJson,
			extraFileUploadParams: {
				uid: ke_Uid
			}
		});
		updata_fields_editor.loadPlugin('insertfile', function() {
			updata_fields_editor.plugin.fileDialog({
				fileUrl : $('#'+file_box).textbox('getValue'),
				clickFn : function(url, title) {
					$('#'+file_box).textbox('setValue',url);
					updata_fields_editor.hideDialog();
				}
			});			
		});
	});
}

/* 上传图片 */

function updata_image(image_box){
	KindEditor.ready(function(K) {
		var updata_image_editor = K.editor({
			allowFileManager : true,
			pasteType:ke_pasteType,
			fileManagerJson: ke_fileManagerJson,
			uploadJson: ke_uploadJson,
			extraFileUploadParams: {
				uid: ke_Uid
			}
		});
		updata_image_editor.loadPlugin("image", function() {
			updata_image_editor.plugin.imageDialog({
				imageUrl : $('#'+image_box).textbox('getValue'),
				clickFn : function(url, title, width, height, border, align) {
					$('#'+image_box).textbox('setValue',url);
					updata_image_editor.hideDialog();
				}
			});
		});
	});
}

(function($, K) {
	
	
	if (!K) throw "KindEditor未定义!";
	
	function create(target) {
		var opts = $.data(target, 'kindeditor').options;
		var editor = K.create(target, opts);
		$.data(target, 'kindeditor').options.editor = editor;
	}

	$.fn.kindeditor = function(options, param) {
		if (typeof options == 'string') {
			var method = $.fn.kindeditor.methods[options];
			if (method) {
				return method(this, param);
			}
		}
		options = options || {};
		return this.each(function() {
			
			if($(this).attr('config_date')==0){
				config_date=['fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline', 'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist', 'insertunorderedlist', '|', 'emoticons', 'image', 'link'];
			}else if($(this).attr('config_date')==1){
				config_date=[
		'source', '|', 'undo', 'redo', '|', 'preview', 'print', 'template', 'code', 'cut', 'copy', 'paste',
		'plainpaste', 'wordpaste', '|', 'justifyleft', 'justifycenter', 'justifyright',
		'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript',
		'superscript', 'clearhtml', 'quickformat', 'selectall', '|', 'fullscreen', '/',
		'formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold',
		'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '|', 'image', 'multiimage',
		'flash', 'media', 'insertfile', 'table', 'hr', 'emoticons', 'baidumap', 'pagebreak',
		'anchor', 'link', 'unlink', '|', 'about'
	];
			}else{
				config_date=['fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline', 'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist', 'insertunorderedlist', '|', 'emoticons', 'image', 'link'];
			}
			
			var state = $.data(this, 'kindeditor');
			if (state) {
				$.extend(state.options, options);
			} else {
				state = $.data(this, 'kindeditor', {
					options: $.extend(
					{},
					{
						resizeType: 1,
						allowPreviewEmoticons: false,
						allowImageUpload: false,
						items: config_date,
						allowFileManager : true,
						pasteType:ke_pasteType,
						fileManagerJson: ke_fileManagerJson,
						uploadJson: ke_uploadJson,
						extraFileUploadParams: {
							uid: ke_Uid
						},
						afterChange: function() {
							this.sync();
						},
						afterBlur: function() {
							this.sync();
						}
					},
					$.fn.kindeditor.parseOptions(this), options)
				});
			}
			create(this);
		});
	}

	$.fn.kindeditor.parseOptions = function(target) {
		return $.extend({},
		$.parser.parseOptions(target, []));
	};

	$.fn.kindeditor.methods = {
		editor: function(jq) {
			return $.data(jq[0], 'kindeditor').options.editor;
		}
	};
	$.parser.plugins.push("kindeditor");
})(jQuery, KindEditor);
