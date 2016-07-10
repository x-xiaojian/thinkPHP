<?php

/*
 * 配置模型控制器
 * Auth : Ghj
 * Time : 2015年4月11日
 * QQ : 912524639
 * Email : 912524639@qq.com
 * Site : http://guanblog.sinaapp.com/
 */
namespace Admin\Controller;

class ConfigController extends AdminController {
	public $Model = null;
	protected function _initialize() {
		parent::_initialize ();
		$this->Model = D ( 'Config' );
	}
	
	/*
	 * 列表(默认首页)
	 * Auth : Ghj
	 * Time : 2015年07月01日
	 */
	public function index() {
		if (IS_POST) {
			$post_data = I ( 'post.' );
			$post_data ['first'] = $post_data ['rows'] * ($post_data ['page'] - 1);
			$map = array ();
			$map = $this->_search ();
			$total = $this->Model->where ( $map )->count ();
			if ($total == 0) {
				$_list = '';
			} else {
				$_list = $this->Model->where ( $map )->order ( $post_data ['sort'] . ' ' . $post_data ['order'] )->limit ( $post_data ['first'] . ',' . $post_data ['rows'] )->select ();
			}
			$option ["status"] = array (
					1 => '启用',
					0 => '禁用' 
			);
			
			foreach ( $_list as $list_key => $list_one ) {
				foreach ( $list_one as $list_one_key => $list_one_field ) {
					if ($option [$list_one_key] != '') {
						$_list [$list_key] [$list_one_key] = $option [$list_one_key] [$list_one_field];
					}
				}
				
				$_list [$list_key] ['operate'] = $this->list_operate ( $_list [$list_key] ['id'] );
				;
			}
			$data = array (
					'total' => $total,
					'rows' => $_list 
			);
			$this->ajaxReturn ( $data );
		} else {
			$this->assign ( 'operate', $this->menu_operate ( 'list' ) );
			$this->display ();
		}
	}
	
	/*
	 * 搜索
	 * Auth : Ghj
	 * Time : 2015年07月01日
	 */
	protected function _search() {
		$map = array ();
		$post_data = I ( 'post.' );
		/* 名称：配置名称 字段：name 类型：string */
		if ($post_data ['s_name'] != '') {
			$map ['name'] = array (
					'like',
					'%' . $post_data ['s_name'] . '%' 
			);
		}
		/* 名称：配置类型 字段：type 类型：string */
		if ($post_data ['s_type'] != '') {
			$map ['type'] = array (
					'like',
					'%' . $post_data ['s_type'] . '%' 
			);
		}
		/* 名称：配置标题 字段：title 类型：string */
		if ($post_data ['s_title'] != '') {
			$map ['title'] = array (
					'like',
					'%' . $post_data ['s_title'] . '%' 
			);
		}
		/* 名称：配置分组 字段：group 类型：string */
		if ($post_data ['s_group'] != '') {
			$map ['group'] = array (
					'like',
					'%' . $post_data ['s_group'] . '%' 
			);
		}
		/* 名称：配置参数 字段：extra 类型：textarea */
		if ($post_data ['s_extra'] != '') {
			$map ['extra'] = array (
					'like',
					'%' . $post_data ['s_extra'] . '%' 
			);
		}
		/* 名称：说明 字段：remark 类型：textarea */
		if ($post_data ['s_remark'] != '') {
			$map ['remark'] = array (
					'like',
					'%' . $post_data ['s_remark'] . '%' 
			);
		}
		/* 名称：状态 字段：status 类型：select */
		if ($post_data ['s_status'] != '') {
			$map ['status'] = $post_data ['s_status'];
		}
		/* 名称：配置值 字段：value 类型：textarea */
		if ($post_data ['s_value'] != '') {
			$map ['value'] = array (
					'like',
					'%' . $post_data ['s_value'] . '%' 
			);
		}
		/* 名称：排序 字段：sort 类型：num */
		if ($post_data ['s_sort'] != '') {
			$map ['sort'] = $post_data ['s_sort'];
		}
		return $map;
	}
	
	/*
	 * 添加
	 * Auth : Ghj
	 * Time : 2015年07月01日
	 */
	public function add() {
		if (IS_POST) {
			$post_data = I ( 'post.' );
			
			$data = $this->Model->create ( $post_data );
			if ($data) {
				$result = $this->Model->add ( $data );
				if ($result) {
					S ( 'DB_CONFIG_DATA', null );
					$this->success ( "操作成功！", U ( 'index' ) );
				} else {
					$error = $this->Model->getError ();
					$this->error ( $error ? $error : "操作失败！" );
				}
			} else {
				$error = $this->Model->getError ();
				$this->error ( $error ? $error : "操作失败！" );
			}
		} else {
			$this->assign ( 'operate', $this->menu_operate ( 'add' ) );
			$this->display ();
		}
	}
	
	/*
	 * 编辑
	 * Auth : Ghj
	 * Time : 2015年07月01日
	 */
	public function edit() {
		if (IS_POST) {
			$post_data = I ( 'post.' );
			
			$data = $this->Model->create ( $post_data );
			if ($data) {
				$result = $this->Model->where ( array (
						'id' => $post_data ['id'] 
				) )->save ( $data );
				if ($result) {
					S ( 'DB_CONFIG_DATA', null );
					$this->success ( "操作成功！", U ( 'index' ) );
				} else {
					$error = $this->Model->getError ();
					$this->error ( $error ? $error : "操作失败！" );
				}
			} else {
				$error = $this->Model->getError ();
				$this->error ( $error ? $error : "操作失败！" );
			}
		} else {
			$_info = I ( 'get.' );
			$_info = $this->Model->where ( array (
					'id' => $_info ['id'] 
			) )->find ();
			$this->assign ( '_info', $_info );
			$this->assign ( 'operate', $this->menu_operate ( 'edit' ) );
			$this->display ();
		}
	}
	
	/*
	 * 删除
	 * Auth : Ghj
	 * Time : 2015年07月01日
	 */
	public function del() {
		$id = I ( 'get.id' );
		empty ( $id ) && $this->error ( '参数不能为空！' );
		$res = $this->Model->delete ( $id );
		if (! $res) {
			$this->error ( $this->Model->getError () );
		} else {
			$this->success ( '删除成功！' );
		}
	}
	
	/*
	 * 批量配置
	 * Auth : Ghj
	 * Time : 2015年06月20日
	 */
	public function group() {
		if (IS_POST) {
			$config = I ( 'post.config' );
			if ($config && is_array ( $config )) {
				foreach ( $config as $name => $value ) {
					$map = array (
							'name' => $name 
					);
					M ( 'Config' )->where ( $map )->setField ( 'value', $value );
				}
			}
			S ( 'DB_CONFIG_DATA', null );
			$this->success ( '保存成功！', U ( '?id=' . I ( 'get.id' ) ) );
		} else {
			$id = I ( 'get.id', 1 );
			$type = model_field_attr ( C ( 'CONFIG_GROUP_LIST' ) );
			$list = M ( "Config" )->where ( array (
					'status' => 1,
					'group' => $id 
			) )->field ( 'id,name,title,extra,value,remark,type' )->order ( 'sort' )->select ();
			if ($list) {
				$this->assign ( 'list', $list );
			}
			$this->assign ( 'type', $type );
			$this->assign ( 'id', $id );
			$this->assign ( 'operate', $this->menu_operate ( 'group' ) );
			$this->display ();
		}
	}
	
	/*
	 * 记录菜单
	 * Auth : Ghj
	 * Time : 2015年06月20日
	 */
	public function list_operate($id) {
		return "
		<a href='#' onclick=\"UpdateTabs('Config','" . U ( 'edit', array (
				'id' => $id 
		) ) . "','','iconfont icon-edit');\">编辑</a>
		<a href='#' onclick=\"Data_Remove('" . U ( 'del', array (
				'id' => $id 
		) ) . "','Config_Data_List');\">删除</a>
		";
	}
	
	/*
	 * 顶部菜单
	 * Auth : Ghj
	 * Time : 2015年06月20日
	 */
	public function menu_operate($type = 'list') {
		if ($type == 'list') {
			return "
			<a class='easyui-linkbutton' href='JavaScript:void(0);' data-options=\"iconCls:'iconfont icon-viewlist',plain:true\" onclick=\"Data_Reload('Config_Data_List');\"><span>管理</span></a>
			<a class='easyui-linkbutton' href='JavaScript:void(0);' data-options=\"iconCls:'iconfont icon-add',plain:true\" onclick=\"UpdateTabs('Config','" . U ( 'add' ) . "','','iconfont icon-add');\"><span>新增</span></a>
			<a class='easyui-linkbutton' href='JavaScript:void(0);' data-options=\"iconCls:'iconfont icon-search',plain:true\" onclick=\"Data_Search('Config_Search_From','Config_Data_List');\"><span>搜索</span></a>
			<a class='easyui-linkbutton' href='JavaScript:void(0);' data-options=\"iconCls:'iconfont icon-refresh',plain:true\" onclick=\"Data_Reload('Config_Data_List');\"><span>刷新</span></a>";
		} elseif ($type == 'add') {
			return "<a class='easyui-linkbutton' href='JavaScript:void(0);' data-options=\"iconCls:'iconfont icon-viewlist',plain:true\" onclick=\"UpdateTabs('Config','" . U ( 'index' ) . "','','iconfont icon-viewlist');\"><span>管理</span></a>
			<a class='easyui-linkbutton' href='JavaScript:void(0);' data-options=\"iconCls:'iconfont icon-add',plain:true\"><span>新增</span></a>";
		} elseif ($type == 'edit') {
			return "<a class='easyui-linkbutton' href='JavaScript:void(0);' data-options=\"iconCls:'iconfont icon-viewlist',plain:true\" onclick=\"UpdateTabs('Config','" . U ( 'index' ) . "','','iconfont icon-viewlist');\"><span>管理</span></a>
			<a class='easyui-linkbutton' href='JavaScript:void(0);' data-options=\"iconCls:'iconfont icon-add',plain:true\" onclick=\"UpdateTabs('Config','" . U ( 'add' ) . "','','iconfont icon-add');\"><span>新增</span></a>
			<a class='easyui-linkbutton' href='JavaScript:void(0);' data-options=\"iconCls:'iconfont icon-edit',plain:true\"><span>编辑</span></a>";
		} else {
			return "<a class='easyui-linkbutton' href='JavaScript:void(0);' data-options=\"iconCls:'iconfont icon-viewlist',plain:true\" onclick=\"Data_Reload('Config_Data_List');\"><span>管理</span></a>";
		}
	}
}