<?php

/*
 * 用户组及权限模型控制器
 * Auth : Ghj
 * Time : 2015年07月01日
 * QQ : 912524639
 * Email : 912524639@qq.com
 * Site : http://guanblog.sinaapp.com/
 */
namespace Admin\Controller;

class AuthGroupController extends AdminController {
	public $Model = null;
	protected function _initialize() {
		parent::_initialize ();
		$this->Model = D ( 'AuthGroup' );
	}
	
	/*
	 * 列表(默认首页)
	 * Auth : Ghj
	 * Time : 2015年07月01日
	 */
	public function index() {
		if (IS_POST) {
			$map = array ();
			$_list = $this->Model->where ( $map )->order ( 'id asc' )->getField ( 'id,pid,title,status,rules' );
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
			$data = list_to_tree ( $_list, 'id', 'pid', 'children' );
			$this->ajaxReturn ( $data );
		} else {
			$this->assign ( 'operate', $this->menu_operate ( 'list' ) );
			$this->display ();
		}
	}
	
	/*
	 * 添加
	 * Auth : Ghj
	 * Time : 2015年07月01日
	 */
	public function add() {
		if (IS_POST) {
			$post_data = I ( 'post.' );
			$post_data ['rules'] = implode ( ',', I ( 'post.rules' ) );
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
	 * Time : 2015年07月01日
	 */
	public function edit() {
		if (IS_POST) {
			$post_data = I ( 'post.' );
			$post_data ['rules'] = implode ( ',', I ( 'post.rules' ) );
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
	 * 记录菜单
	 * Auth : Ghj
	 * Time : 2015年07月01日
	 */
	public function list_operate($id) {
		return "
		<a href='#' onclick=\"UpdateTabs('AuthGroup','" . U ( 'edit', array (
				'id' => $id 
		) ) . "','','iconfont icon-edit');\">编辑</a>
		<a href='#' onclick=\"Data_Remove2('" . U ( 'del', array (
				'id' => $id 
		) ) . "','AuthGroup_Data_List');\">删除</a>
		";
	}
	
	/*
	 * 顶部菜单
	 * Auth : Ghj
	 * Time : 2015年07月01日
	 */
	public function menu_operate($type = 'list') {
		if ($type == 'list') {
			return "
			<a class='easyui-linkbutton' href='JavaScript:void(0);' data-options=\"iconCls:'iconfont icon-viewlist',plain:true\" onclick=\"Data_Reload2('AuthGroup_Data_List');\"><span>管理</span></a>
			<a class='easyui-linkbutton' href='JavaScript:void(0);' data-options=\"iconCls:'iconfont icon-add',plain:true\" onclick=\"UpdateTabs('AuthGroup','" . U ( 'add' ) . "','','iconfont icon-add');\"><span>新增</span></a>
			<a class='easyui-linkbutton' href='JavaScript:void(0);' data-options=\"iconCls:'iconfont icon-refresh',plain:true\" onclick=\"Data_Reload2('AuthGroup_Data_List');\"><span>刷新</span></a>";
		} elseif ($type == 'add') {
			return "<a class='easyui-linkbutton' href='JavaScript:void(0);' data-options=\"iconCls:'iconfont icon-viewlist',plain:true\" onclick=\"UpdateTabs('AuthGroup','" . U ( 'index' ) . "','','iconfont icon-viewlist');\"><span>管理</span></a>
			<a class='easyui-linkbutton' href='JavaScript:void(0);' data-options=\"iconCls:'iconfont icon-add',plain:true\"><span>新增</span></a>";
		} elseif ($type == 'edit') {
			return "<a class='easyui-linkbutton' href='JavaScript:void(0);' data-options=\"iconCls:'iconfont icon-viewlist',plain:true\" onclick=\"UpdateTabs('AuthGroup','" . U ( 'index' ) . "','','iconfont icon-viewlist');\"><span>管理</span></a>
			<a class='easyui-linkbutton' href='JavaScript:void(0);' data-options=\"iconCls:'iconfont icon-add',plain:true\" onclick=\"UpdateTabs('AuthGroup','" . U ( 'add' ) . "','','iconfont icon-add');\"><span>新增</span></a>
			<a class='easyui-linkbutton' href='JavaScript:void(0);' data-options=\"iconCls:'iconfont icon-edit',plain:true\"><span>编辑</span></a>";
		} else {
			return "<a class='easyui-linkbutton' href='JavaScript:void(0);' data-options=\"iconCls:'iconfont icon-viewlist',plain:true\" onclick=\"Data_Reload2('AuthGroup_Data_List');\"><span>管理</span></a>";
		}
	}
	/*
	 * 获取树
	 * Auth : Ghj
	 * Time : 2015年4月16日
	 */
	public function get_auth_group($is_g = '') {
		$map ['status'] = 1;
		$_list = $this->Model->where ( $map )->order ( 'id asc' )->getField ( 'id,pid,title as text' );
		if ($is_g == '') {
			$_list [] = array (
					'id' => '0',
					'pid' => '-1',
					'text' => '无' 
			);
			$data = list_to_tree ( $_list, 'id', 'pid', 'children', '-1' );
		} else {
			$data = list_to_tree ( $_list, 'id', 'pid', 'children' );
		}
		echo json_encode ( $data );
	}
	
	/*
	 * 获取树
	 * Auth : Ghj
	 * Time : 2015年4月16日
	 */
	public function get_auth_role() {
		$map ['status'] = 1;
		$_list = M ( 'AuthRule' )->where ( $map )->order ( 'sort asc' )->getField ( 'id,pid,title as text' );
		$data = list_to_tree ( $_list, 'id', 'pid', 'children' );
		echo json_encode ( $data );
	}
}