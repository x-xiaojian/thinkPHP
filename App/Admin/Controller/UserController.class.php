<?php

/*
 * 用户模型控制器
 * Auth : Ghj
 * Time : 2015年07月03日
 * QQ : 912524639
 * Email : 912524639@qq.com
 * Site : http://guanblog.sinaapp.com/
 */
namespace Admin\Controller;

class UserController extends AdminController {
	public $Model = null;
	protected function _initialize() {
		parent::_initialize ();
		$this->Model = D ( 'User' );
	}
	
	/*
	 * 列表(默认首页)
	 * Auth : Ghj
	 * Time : 2015年07月03日
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
			$option ["group_id"] = M ( 'AuthGroup' )->order ( 'id asc' )->getField ( 'id,title' );
			
			foreach ( $_list as $list_key => $list_one ) {
				foreach ( $list_one as $list_one_key => $list_one_field ) {
					if ($option [$list_one_key] != '') {
						$_list [$list_key] [$list_one_key] = $option [$list_one_key] [$list_one_field];
					}
				}
				$_list [$list_key] ["create_time"] = date ( "Y年m月d日 H时i分s秒", $_list [$list_key] ["create_time"] );
				$_list [$list_key] ["update_time"] = date ( "Y年m月d日 H时i分s秒", $_list [$list_key] ["update_time"] );
				$_list [$list_key] ["logdatetime"] = date ( "Y年m月d日 H时i分s秒", $_list [$list_key] ["logdatetime"] );
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
	 * Time : 2015年07月03日
	 */
	protected function _search() {
		$map = array ();
		$post_data = I ( 'post.' );
		/* 名称：用户名 字段：username 类型：string */
		if ($post_data ['s_username'] != '') {
			$map ['username'] = array (
					'like',
					'%' . $post_data ['s_username'] . '%' 
			);
		}
		/* 名称：真实姓名 字段：nickname 类型：string */
		if ($post_data ['s_nickname'] != '') {
			$map ['nickname'] = array (
					'like',
					'%' . $post_data ['s_nickname'] . '%' 
			);
		}
		/* 名称：用户密码 字段：password 类型：string */
		if ($post_data ['s_password'] != '') {
			$map ['password'] = array (
					'like',
					'%' . $post_data ['s_password'] . '%' 
			);
		}
		/* 名称：注册类型 字段：group_id 类型：string */
		if ($post_data ['s_group_id'] != '') {
			$map ['group_id'] = array (
					'like',
					'%' . $post_data ['s_group_id'] . '%' 
			);
		}
		/* 名称：注册日期 字段：create_time 类型：datetime */
		if ($post_data ['s_create_time_min'] != '') {
			$map ['create_time'] [] = array (
					'gt',
					strtotime ( $post_data ['s_create_time_min'] ) 
			);
		}
		if ($post_data ['s_create_time_max'] != '') {
			$map ['create_time'] [] = array (
					'lt',
					strtotime ( $post_data ['s_create_time_max'] ) 
			);
		}
		/* 名称：最后修改时间 字段：update_time 类型：datetime */
		if ($post_data ['s_update_time_min'] != '') {
			$map ['update_time'] [] = array (
					'gt',
					strtotime ( $post_data ['s_update_time_min'] ) 
			);
		}
		if ($post_data ['s_update_time_max'] != '') {
			$map ['update_time'] [] = array (
					'lt',
					strtotime ( $post_data ['s_update_time_max'] ) 
			);
		}
		/* 名称：上次登录IP 字段：logip 类型：string */
		if ($post_data ['s_logip'] != '') {
			$map ['logip'] = array (
					'like',
					'%' . $post_data ['s_logip'] . '%' 
			);
		}
		/* 名称：上次登录时间 字段：logdatetime 类型：datetime */
		if ($post_data ['s_logdatetime_min'] != '') {
			$map ['logdatetime'] [] = array (
					'gt',
					strtotime ( $post_data ['s_logdatetime_min'] ) 
			);
		}
		if ($post_data ['s_logdatetime_max'] != '') {
			$map ['logdatetime'] [] = array (
					'lt',
					strtotime ( $post_data ['s_logdatetime_max'] ) 
			);
		}
		/* 名称：备注 字段：remark 类型：textarea */
		if ($post_data ['s_remark'] != '') {
			$map ['remark'] = array (
					'like',
					'%' . $post_data ['s_remark'] . '%' 
			);
		}
		/* 名称：验证/状态 字段：status 类型：select */
		if ($post_data ['s_status'] != '') {
			$map ['status'] = $post_data ['s_status'];
		}
		return $map;
	}
	
	/*
	 * 添加
	 * Auth : Ghj
	 * Time : 2015年07月03日
	 */
	public function add() {
		if (IS_POST) {
			$post_data = I ( 'post.' );
			$post_data ["create_time"] = strtotime ( $post_data ["create_time"] );
			$post_data ["update_time"] = strtotime ( $post_data ["update_time"] );
			$post_data ["logdatetime"] = strtotime ( $post_data ["logdatetime"] );
			
			$data = $this->Model->create ( $post_data );
			if ($data) {
				$result = $this->Model->add ( $data );
				if ($result) {
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
	 * Time : 2015年07月03日
	 */
	public function edit() {
		if (IS_POST) {
			$post_data = I ( 'post.' );
			$post_data ["create_time"] = strtotime ( $post_data ["create_time"] );
			$post_data ["update_time"] = strtotime ( $post_data ["update_time"] );
			$post_data ["logdatetime"] = strtotime ( $post_data ["logdatetime"] );
			
			$data = $this->Model->create ( $post_data );
			if ($data) {
				$result = $this->Model->where ( array (
						'id' => $post_data ['id'] 
				) )->save ( $data );
				if ($result) {
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
	 * Time : 2015年07月03日
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
	 * 记录菜单
	 * Auth : Ghj
	 * Time : 2015年06月20日
	 */
	public function list_operate($id) {
		return "
		<a href='#' onclick=\"UpdateTabs('User','" . U ( 'edit', array (	'id' => $id ) ) . "','','iconfont icon-edit');\">编辑</a>
		<a href='#' onclick=\"Data_Remove('" . U ( 'del', array ( 'id' => $id 	) ) . "','User_Data_List');\">删除</a>
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
			<a class='easyui-linkbutton' href='JavaScript:void(0);' data-options=\"iconCls:'iconfont icon-viewlist',plain:true\" onclick=\"Data_Reload('User_Data_List');\"><span>管理</span></a>
			<a class='easyui-linkbutton' href='JavaScript:void(0);' data-options=\"iconCls:'iconfont icon-add',plain:true\" onclick=\"UpdateTabs('User','" . U ( 'add' ) . "','','iconfont icon-add');\"><span>新增</span></a>
			<a class='easyui-linkbutton' href='JavaScript:void(0);' data-options=\"iconCls:'iconfont icon-search',plain:true\" onclick=\"Data_Search('User_Search_From','User_Data_List');\"><span>搜索</span></a>
			<a class='easyui-linkbutton' href='JavaScript:void(0);' data-options=\"iconCls:'iconfont icon-refresh',plain:true\" onclick=\"Data_Reload('User_Data_List');\"><span>刷新</span></a>";
		} elseif ($type == 'add') {
			return "<a class='easyui-linkbutton' href='JavaScript:void(0);' data-options=\"iconCls:'iconfont icon-viewlist',plain:true\" onclick=\"UpdateTabs('User','" . U ( 'index' ) . "','','iconfont icon-viewlist');\"><span>管理</span></a>
			<a class='easyui-linkbutton' href='JavaScript:void(0);' data-options=\"iconCls:'iconfont icon-add',plain:true\"><span>新增</span></a>";
		} elseif ($type == 'edit') {
			return "<a class='easyui-linkbutton' href='JavaScript:void(0);' data-options=\"iconCls:'iconfont icon-viewlist',plain:true\" onclick=\"UpdateTabs('User','" . U ( 'index' ) . "','','iconfont icon-viewlist');\"><span>管理</span></a>
			<a class='easyui-linkbutton' href='JavaScript:void(0);' data-options=\"iconCls:'iconfont icon-add',plain:true\" onclick=\"UpdateTabs('User','" . U ( 'add' ) . "','','iconfont icon-add');\"><span>新增</span></a>
			<a class='easyui-linkbutton' href='JavaScript:void(0);' data-options=\"iconCls:'iconfont icon-edit',plain:true\"><span>编辑</span></a>";
		} else {
			return "<a class='easyui-linkbutton' href='JavaScript:void(0);' data-options=\"iconCls:'iconfont icon-viewlist',plain:true\" onclick=\"Data_Reload('User_Data_List');\"><span>管理</span></a>";
		}
	}
}