<?php

/*
 * 后台基类
 * Auth : Ghj
 * Time : 2015年4月11日
 * QQ : 912524639
 * Email : 912524639@qq.com
 * Site : http://guanblog.sinaapp.com/
 */
namespace Admin\Controller;

use Common\Controller\CoreController;
use Org\Util\Auth;

class AdminController extends CoreController {
	protected function _initialize() {
		if (session ( C ( 'AUTH_KEY' ) ) < 1) {
			redirect ( U ( C ( 'AUTH_USER_GATEWAY' ) ) );
		} else {
			$Auth = new Auth ();
			if (! in_array ( session ( C ( 'AUTH_KEY' ) ), C ( 'AUTH_ADMIN' ) ) && ! in_array ( CONTROLLER_NAME, explode ( ",", C ( "NOT_AUTH_MODULE" ) ) )) {
				if (! $Auth->check ( MODULE_NAME . '/' . CONTROLLER_NAME . '/' . ACTION_NAME, session ( C ( 'AUTH_KEY' ) ) )) {
					$this->error ( '你没有权限' . MODULE_NAME . '/' . CONTROLLER_NAME . '/' . ACTION_NAME );
				}
			}
		}
	}
	public function GetMenu() {
		$menus = session ( 'ADMIN_MENU_LIST' );
		if (count ( $menus ) != 999) {
			if (in_array ( session ( C ( 'AUTH_KEY' ) ), C ( 'AUTH_ADMIN' ) )) {
				$map = array (
						'is_hide' => 0,
						'status' => 1 
				);
			} else {
				$Auth = new Auth ();
				$groups = $Auth->getGroups ( session ( C ( 'AUTH_KEY' ) ) );
				$ids = array ();
				foreach ( $groups as $g ) {
					$ids = array_merge ( $ids, explode ( ',', trim ( $g ['rules'], ',' ) ) );
				}
				$ids = array_unique ( $ids );
				$map = array (
						'id' => array (
								'in',
								$ids 
						),
						'is_hide' => 0,
						'status' => 1 
				);
			}
			// 读取用户组所有权限规则
			$rules = M ( 'AuthRule' )->where ( $map )->field ( 'id,pid,name,title,icon as iconCls' )->order ( 'sort asc' )->select ();
			// $rules = M('AuthRule')->where($map)->order('sort asc')->getField('id,pid,name,title as text');
			foreach ( $rules as $rid => $rules_one ) {
				$rules [$rid] ['attributes'] = array (
						"url" => U ( $rules_one ['name'] ),
						"rule" => $rules_one ['name'] 
				);
				$rules [$rid] ['text'] = $rules_one ['title'];
			}
			$menus = list_to_tree ( $rules, $pk = 'id', $pid = 'pid', 'children' );
			session ( 'ADMIN_MENU_LIST', '' );
			session ( 'ADMIN_MENU_LIST', $menus );
		}
		return $menus;
	}
}